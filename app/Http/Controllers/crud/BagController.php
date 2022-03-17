<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\BagCreate;
use App\Http\Requests\BagDelete;
use App\Http\Requests\BagEdit;
use App\Http\Requests\CreateOrder;
use App\Http\Requests\ProductCheck;
use App\Mail\BuyProduct;
use App\Mail\SubProduct;
use App\Models\Bag;
use App\Models\Order;
use App\Models\Subscription;
use App\Services\interfaces\BagsRepositoryInterface;
use App\Services\interfaces\MailSenderInterface;
use App\Services\interfaces\SubscribeRepositoryInterface;
use App\Services\interfaces\UserRepositoryInterface;
use App\Services\traits\ReturnWithRedirectAndFlash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BagController extends Controller
{
    use ReturnWithRedirectAndFlash;

    /**
     * @param Request $request
     */
    public function __construct(protected Request $request)
    {
    }

    /**
     * Метод отвечает за сохранение данных о новом товаре в БД
     *
     * @param BagCreate $validate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(BagCreate $validate)
    {
        // Сохранение файла изображения
        $file = $this->request->file('image');
        $image_path = $file->store('bags_preview', 'public');

        if (!$image_path) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Image save failed',
                route('admin.bags.create.form'),
                $this->request
            );
        }

        // Сохранение данных в БД
        $model = new Bag;
        $model->name = $this->request->input('name');
        $model->description = $this->request->input('description');
        $model->price = $this->request->input('price');
        $model->discount_price = $this->request->input('discount_price');
        $model->count = $this->request->input('count');
        $model->image = $image_path;

        if (!$model->save()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Model save failed',
                route('admin.bags.create.form'),
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product added successfully',
            route('admin.bags'),
            $this->request
        );
    }

    /**
     * Метод отвечает за редактирование данных товара с переданным id
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @param BagEdit $validate
     * @return mixed
     */
    public function edit(
        BagsRepositoryInterface $bagsRepository,
        BagEdit $validate
    )
    {
        $bag = $bagsRepository->getFistOrNull($this->request->input('id'));

        // Передано ли новое изображение. Если да - удалить старое, сохранить новое
        if ($this->request->hasFile('image')) {

            if (!Storage::disk('public')->delete($bag->image)) {
                return $this->withRedirectAndFlash(
                    'status_failed',
                    'Old image delete failed',
                    route('admin.bags.edit.form', ['id' => $bag->id]),
                    $this->request
                );
            }


            // Сохранение нового файла изображения
            $file = $this->request->file('image');
            $bag->image = $file->store('bags_preview', 'public');

            if (!$bag->image) {
                return $this->withRedirectAndFlash(
                    'status_failed',
                    'New image save failed',
                    route('admin.bags.edit.form', ['id' => $bag->id]),
                    $this->request
                );
            }
        }

        // Сохранение переданных данных
        $bag->name = $this->request->input('name');
        $bag->description = $this->request->input('description');
        $bag->price = $this->request->input('price');
        $bag->discount_price = $this->request->input('discount_price');
        $bag->count = $this->request->input('count');

        if (!$bag->save()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Product save failed',
                route('admin.bags.edit.form', ['id' => $bag->id]),
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product edited successfully',
            route('admin.bags', ['id' => $bag->id]),
            $this->request
        );
    }

    /**
     * Метод отвечает за удаление товара из таблицы 'bags'
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @param BagDelete $validate
     * @return mixed
     */
    public function delete(
        BagsRepositoryInterface $bagsRepository,
        BagDelete $validate
    )
    {
        $bag_id = $this->request->input('id');
        $bag = $bagsRepository->getFistOrNull($bag_id);
        $bab_image = $bag->image;

        // Удаление товара
        if (!$bag->delete()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Product delete failed"',
                route('admin.bags'),
                $this->request
            );
        }

        // Удаление изображения товара
        if (!Storage::disk('public')->delete($bab_image)) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Image delete failed',
                route('admin.bags'),
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product delete successfully',
            route('admin.bags'),
            $this->request
        );
    }

    /**
     * Метод отвечает за отправку сообщения о товаре на почту
     *
     * @param int $id идентификатор товара
     * @param BagsRepositoryInterface $bagsRepository
     * @param ProductCheck $validate
     * @return mixed
     */
    public function productCheck(
        int $id,
        BagsRepositoryInterface $bagsRepository,
        MailSenderInterface $mailer,
        ProductCheck $validate
    ) {
        // Получение экземпляра товара
        $bag = $bagsRepository->getFistOrNull($id);

        if (!$bag) {
            return redirect(route('home'));
        }

        // Определение класса почты
        $mail = null;

        if ($bag->count > 0) {
            $mail = new BuyProduct($bag);
        } else {
            $mail = new SubProduct($bag);
        }

        // Отправка почты
        $mailer->queue($mail, $this->request->query('email'));

        return $this->withRedirectAndFlash(
            'email_send',
            'Check your email',
            route('single', ['bag' => $bag->slug]),
            $this->request
        );
    }

    /**
     * Метод отвечает за сохранение данных о заказе в таблице 'orders'
     *
     * @param UserRepositoryInterface $userRepository
     * @param BagsRepositoryInterface $bagsRepository
     * @param CreateOrder $validate
     * @return mixed
     */
    public function createOrder(
        UserRepositoryInterface $userRepository,
        BagsRepositoryInterface $bagsRepository,
        CreateOrder $validate
    ) {
        // Получение данных для заполнения информации о заказе
        $bag_slug = $this->request->input('bag');
        $bag = $bagsRepository->getFirstWhereOrNull([['slug', '=', $bag_slug]]);

        // Проверка количества товара
        if (($bag->count <= 0)) {
            return $this->withRedirectAndFlash(
                'email_send',
                'Error',
                route('single', ['bag' => $bag->slug]),
                $this->request
            );
        }

        $bag_id = $bag->id;
        $user_id = $userRepository->getAuthenticated()->id;


        // Заполнение и сохранение данных заказа
        $order = new Order;
        $order->user_id = $user_id;
        $order->bag_id = $bag_id;
        $order->name = $this->request->input('name');
        $order->number = $this->request->input('number');

        if (!$order->save()) {
            return $this->withRedirectAndFlash(
                'email_send',
                'Order create failed',
                route('single', ['bag' => $bag->slug]),
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'email_send',
            'Order created. Wait',
            route('single', ['bag' => $bag->slug]),
            $this->request
        );
    }

    /**
     * Метод отвечает за подписку пользователя на товар
     *
     * @param BagsRepositoryInterface $bagsRepository
     * @param UserRepositoryInterface $userRepository
     * @param SubscribeRepositoryInterface $subscribeRepository
     * @param SubProduct $validate
     * @return mixed
     */
    public function subProduct(
        BagsRepositoryInterface $bagsRepository,
        UserRepositoryInterface $userRepository,
        SubscribeRepositoryInterface $subscribeRepository,
        SubProduct $validate
    ) {
        // Получение данных для заполнения модели
        $user_id = $userRepository->getAuthenticated()->id;
        $bag_slug = $this->request->input('slug');
        $bag_id = $bagsRepository->getFirstWhereOrNull([['slug', '=', $bag_slug]])->id;

        // Проверка, подписан ли уже пользователь
        if ($subscribeRepository->userIsSubscribed($user_id, $bag_id)) {
            return $this->withRedirectAndFlash(
                'sub_status',
                'You already subscribe',
                route('single', ['bag' => $bag_slug]) . '#sub',
                $this->request
            );
        }

        // Сохранение данных в БД
        $model = new Subscription;
        $model->user_id = $user_id;
        $model->bag_id = $bag_id;

        if (!$model->save()) {
            return $this->withRedirectAndFlash(
                'sub_status',
                'Subscription failed',
                route('single', ['bag' => $bag_slug]) . '#sub',
                $this->request
            );
        }

        return $this->withRedirectAndFlash(
            'sub_status',
            'Subscription success',
            route('single', ['bag' => $bag_slug]) . '#sub',
            $this->request
        );
    }
}

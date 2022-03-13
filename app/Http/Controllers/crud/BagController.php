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
     * Метод отвечает за сохранение данных о новом товаре в БД
     *
     * @param Request $request
     * @param BagCreate $validate
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, BagCreate $validate)
    {
        // Сохранение файла изображения
        $file = $request->file('image');
        $image_path = $file->store('bags_preview', 'public');

        if (!$image_path) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Image save failed',
                route('admin.bags.create.form'),
                $request
            );
        }

        // Сохранение данных в БД
        $model = new Bag;
        $model->name = $request->input('name');
        $model->description = $request->input('description');
        $model->price = $request->input('price');
        $model->discount_price = $request->input('discount_price');
        $model->count = $request->input('count');
        $model->image = $image_path;

        if (!$model->save()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Model save failed',
                route('admin.bags.create.form'),
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product added successfully',
            route('admin.bags'),
            $request
        );
    }

    /**
     * Метод отвечает за редактирование данных товара с переданным id
     *
     * @param Request $request
     * @param BagsRepositoryInterface $bagsRepository
     * @param BagEdit $validate
     * @return mixed
     */
    public function edit(
        Request $request,
        BagsRepositoryInterface $bagsRepository,
        BagEdit $validate
    )
    {
        $bag = $bagsRepository->getFistOrNull($request->input('id'));

        // Передано ли новое изображение. Если да - удалить старое, сохранить новое
        if ($request->hasFile('image')) {

            if (!Storage::disk('public')->delete($bag->image)) {
                return $this->withRedirectAndFlash(
                    'status_failed',
                    'Old image delete failed',
                    route('admin.bags.edit.form', ['id' => $bag->id]),
                    $request
                );
            }


            // Сохранение нового файла изображения
            $file = $request->file('image');
            $bag->image = $file->store('bags_preview', 'public');

            if (!$bag->image) {
                return $this->withRedirectAndFlash(
                    'status_failed',
                    'New image save failed',
                    route('admin.bags.edit.form', ['id' => $bag->id]),
                    $request
                );
            }
        }

        // Сохранение переданных данных
        $bag->name = $request->input('name');
        $bag->description = $request->input('description');
        $bag->price = $request->input('price');
        $bag->discount_price = $request->input('discount_price');
        $bag->count = $request->input('count');

        if (!$bag->save()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Product save failed',
                route('admin.bags.edit.form', ['id' => $bag->id]),
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product edited successfully',
            route('admin.bags', ['id' => $bag->id]),
            $request
        );
    }

    /**
     * Метод отвечает за удаление товара из таблицы 'bags'
     *
     * @param Request $request
     * @param BagsRepositoryInterface $bagsRepository
     * @param BagDelete $validate
     * @return mixed
     */
    public function delete(
        Request $request,
        BagsRepositoryInterface $bagsRepository,
        BagDelete $validate
    )
    {
        $bag_id = $request->input('id');
        $bag = $bagsRepository->getFistOrNull($bag_id);
        $bab_image = $bag->image;

        // Удаление товара
        if (!$bag->delete()) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Product delete failed"',
                route('admin.bags'),
                $request
            );
        }

        // Удаление изображения товара
        if (!Storage::disk('public')->delete($bab_image)) {
            return $this->withRedirectAndFlash(
                'status_failed',
                'Image delete failed',
                route('admin.bags'),
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'status_success',
            'Product delete successfully',
            route('admin.bags'),
            $request
        );
    }

    /**
     * Метод отвечает за отправку сообщения о товаре на почту
     *
     * @param int $id идентификатор товара
     * @param BagsRepositoryInterface $bagsRepository
     * @param Request $request
     * @param ProductCheck $validate
     * @return mixed
     */
    public function productCheck(
        int $id,
        BagsRepositoryInterface $bagsRepository,
        Request $request,
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
        $mailer->queue($mail, $request->query('email'));

        return $this->withRedirectAndFlash(
            'email_send',
            'Check your email',
            route('single', ['bag' => $bag->slug]),
            $request
        );
    }

    /**
     * Метод отвечает за сохранение данных о заказе в таблице 'orders'
     *
     * @param UserRepositoryInterface $userRepository
     * @param BagsRepositoryInterface $bagsRepository
     * @param Request $request
     * @param CreateOrder $validate
     * @return mixed
     */
    public function createOrder(
        UserRepositoryInterface $userRepository,
        BagsRepositoryInterface $bagsRepository,
        Request $request,
        CreateOrder $validate
    ) {
        // Получение данных для заполнения информации о заказе
        $bag_slug = $request->input('bag');
        $bag = $bagsRepository->getFirstWhereOrNull([['slug', '=', $bag_slug]]);

        // Проверка количества товара
        if (($bag->count <= 0)) {
            return $this->withRedirectAndFlash(
                'email_send',
                'Error',
                route('single', ['bag' => $bag->slug]),
                $request
            );
        }

        $bag_id = $bag->id;
        $user_id = $userRepository->getAuthenticated()->id;


        // Заполнение и сохранение данных заказа
        $order = new Order;
        $order->user_id = $user_id;
        $order->bag_id = $bag_id;
        $order->name = $request->input('name');
        $order->number = $request->input('number');

        if (!$order->save()) {
            return $this->withRedirectAndFlash(
                'email_send',
                'Order create failed',
                route('single', ['bag' => $bag->slug]),
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'email_send',
            'Order created. Wait',
            route('single', ['bag' => $bag->slug]),
            $request
        );
    }

    /**
     * Метод отвечает за подписку пользователя на товар
     *
     * @param Request $request
     * @param BagsRepositoryInterface $bagsRepository
     * @param UserRepositoryInterface $userRepository
     * @param SubscribeRepositoryInterface $subscribeRepository
     * @param SubProduct $validate
     * @return mixed
     */
    public function subProduct(
        Request $request,
        BagsRepositoryInterface $bagsRepository,
        UserRepositoryInterface $userRepository,
        SubscribeRepositoryInterface $subscribeRepository,
        SubProduct $validate
    ) {
        // Получение данных для заполнения модели
        $user_id = $userRepository->getAuthenticated()->id;
        $bag_slug = $request->input('slug');
        $bag_id = $bagsRepository->getFirstWhereOrNull([['slug', '=', $bag_slug]])->id;

        // Проверка, подписан ли уже пользователь
        if ($subscribeRepository->userIsSubscribed($user_id, $bag_id)) {
            return $this->withRedirectAndFlash(
                'sub_status',
                'You already subscribe',
                route('single', ['bag' => $bag_slug]) . '#sub',
                $request
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
                $request
            );
        }

        return $this->withRedirectAndFlash(
            'sub_status',
            'Subscription success',
            route('single', ['bag' => $bag_slug]) . '#sub',
            $request
        );
    }
}

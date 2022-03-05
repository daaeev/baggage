<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Services\interfaces\BagsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BagController extends Controller
{
    /**
     * Метод отвечает за сохранение данных о новом товаре в БД
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        // Валидация полученных данных
        $request->validate([
            'name' => 'required|max:255|unique:\App\Models\Bag,name',
            'price' => 'numeric|required',
            'discount_price' => 'nullable|numeric',
            'count' => 'integer|required',
            'image' => 'required|file|image',
        ]);

        // Сохранение файла изображения
        $file = $request->file('image');
        $image_path = $file->store('bags_preview', 'public');

        if (!$image_path) {
            $request->session()->flash('status_failed', "Image save failed");

            return redirect(route('admin.bags.create.form'));
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
            $request->session()->flash('status_failed', "Model save failed");

            return redirect(route('admin.bags.create.form'));
        }

        $request->session()->flash('status_success', "Product added successfully");

        return redirect(route('admin.bags'));
    }

    /**
     * Метод отвечает за редактирование данных товара с переданным id
     *
     * @param Request $request
     * @param BagsRepositoryInterface $bagsRepository
     * @return mixed
     */
    public function edit(Request $request, BagsRepositoryInterface $bagsRepository)
    {
        // Валидация полученных данных
        $request->validate([
            'id' => 'bail|required|integer|exists:\App\Models\Bag,id',
            'name' => 'required|max:255',
            'price' => 'numeric|required',
            'discount_price' => 'nullable|numeric',
            'count' => 'integer|required',
            'image' => 'nullable|file|image',
        ]);

        $bag = $bagsRepository->getFistOrNull($request->input('id'));

        // Передано ли новое изображение. Если да - удалить старое, сохранить новое
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($bag->image);

            // Сохранение нового файла изображения
            $file = $request->file('image');
            $bag->image = $file->store('bags_preview', 'public');

            if (!$bag->image) {
                $request->session()->flash('status_failed', "Image save failed");

                return redirect(route('admin.bags.edit.form', ['id' => $bag->id]));
            }
        }

        // Сохранение переданных данных
        $bag->name = $request->input('name');
        $bag->description = $request->input('description');
        $bag->price = $request->input('price');
        $bag->discount_price = $request->input('discount_price');
        $bag->count = $request->input('count');

        if (!$bag->save()) {
            $request->session()->flash('status_failed', "Model save failed");

            return redirect(route('admin.bags.edit.form', ['id' => $bag->id]));
        }

        $request->session()->flash('status_success', "Product edited successfully");

        return redirect(route('admin.bags'));
    }
}

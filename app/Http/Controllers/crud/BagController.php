<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}

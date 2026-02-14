@extends('layouts.app')

@section('body-class', 'narrow-page') {{-- 標準サイズ --}}

@section('content')
<p class="mb-4">商品一覧>{{ $product->name }}</p>

<form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4 align-items-start">
        <!-- 左：画像 -->
        <div class="col-md-4">
            <label for="image" class="form-label">商品画像</label>
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-2" style="max-height: 200px; object-fit: cover;">
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- 右：名前、価格、季節 -->
        <div class="col-md-8">
            <div class="mb-3">
                <label for="name" class="form-label">商品名</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$product->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">価格</label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">季節</label><br>
                @foreach ($seasons as $season)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                        class="form-check-input @error('seasons') is-invalid @enderror"
                        {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $season->name }}</label>
                </div>
                @endforeach
                @error('seasons')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <!-- 説明 -->
    <div class="mb-4 mt-4">
        <label for="description" class="form-label">商品説明</label>
        <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
    </div>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror


    {{-- ボタンエリア：中央揃え & 削除を右に配置 --}}
    <div class="d-flex justify-content-center gap-4 mt-2">
        {{-- 左：戻る & 保存 --}}
        <a href="{{ url('/products') }}" class="btn btn-secondary px-5 py-2">← 戻る</a>
        <button type="submit" class="btn btn-warning px-5 py-2">変更を保存</button>
    </div>
</form>


{{-- 右：削除ボタン --}}
<div class="d-flex justify-content-end mt-3">
    <form method="POST" action="{{ route('products.destroy', $product->id) }}"
        onsubmit="return confirm('本当に削除しますか？');" class="ms-auto">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger px-3 py-2">🗑</button>
    </form>
</div>

@endsection

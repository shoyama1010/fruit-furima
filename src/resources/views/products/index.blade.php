@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/products/index.css') }}">
@endpush

@section('content')
@section('body-class', 'wide-page') {{-- 横幅を広くしたい画面 --}}
<div class="container">
    <div class="row">
        <!-- 左カラム：検索フォーム -->
        <div class="col-md-3 mb-4">
            <form method="GET" action="{{ route('products.search') }}">
                @csrf
                <h1> 商品一覧</h1>
                <div class="mb-3">
                    <input type="text" class="form-control" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
                </div>
                <div class="d-grid">
                    <button class="btn btn-warning" type="submit">検索</button>
                </div>

                <!-- ソートボックス -->
                <div class="mb-4">
                    <label for="sort" class="form-label">価格で並べ替え:</label>
                    <select class="form-select" name="sort" onchange="this.form.submit()">
                        <option value="">選択してください</option>
                        <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>安い順に表示</option>
                    </select>
                </div>

                {{-- 並び替えタグ表示（リセット可能） --}}
                @if(request('sort') === 'high' || request('sort') === 'low')
                <div class="mb-3">
                    <span class="badge rounded-pill border border-warning text-warning px-3 py-2">
                        {{ request('sort') === 'high' ? '高い順に表示' : '安い順に表示' }}
                        <a href="{{ route('products.index', request()->except('sort')) }}" class="text-warning ms-2 text-decoration-none">×</a>
                    </span>
                </div>
                @endif

            </form>
        </div>

        <!-- 右カラム：商品一覧と登録ボタン -->
        <div class="col-md-9">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('products.create') }}" class="btn btn-warning">＋ 商品を登録</a>
            </div>

            <!-- 商品カード一覧 -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($products as $product)
                <div class="col">
                    <a href="{{ route('products.edit',$product->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">¥{{ $product->price }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
            <!-- ページネーション -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

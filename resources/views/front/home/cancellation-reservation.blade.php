@extends('front.layouts.app',[
    'nav_type'      =>'white',
    'banner_type'   =>'white',
    'page_title'         =>$page->title,
    'page_sub_title'     =>$page->sub_title,
    'page_img'           =>'/storage/pages/'.$page->img,
])

@section('seo_title', $page->seo_title)

@section('seo_desc', $page->seo_desc)

@section('seo_keys', $page->seo_keys)

@section('content')

<div class="container mx-auto max-w-screen-xl section-p-y ">

    <h3>
        Cancelacion de reserva
    </h3>
</div>

@endsection
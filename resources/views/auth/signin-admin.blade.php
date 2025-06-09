@extends('layouts.signIn-base')

@section('title', 'Log In Admin')

@section('form_action', route('signIn.user.authenticate', ['isAdmin' => true]))

@section('custom_link_first', route('signIn.lecturer'))

@section('custom_link_label_first', 'Dosennn')

@section('custom_link_second', route('signIn.student'))

@section('custom_link_label_second', 'Mahasiswa')

@section('background_url', asset('img/admin-signin-hero.jpg'))
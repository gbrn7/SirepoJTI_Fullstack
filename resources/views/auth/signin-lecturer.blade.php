@extends('layouts.signIn-base')

@section('title', 'Log In Dosen')

@section('form_action', route('signIn.user.authenticate', ['isLecturer' => true]))

@section('custom_link_first', route('signIn.student'))

@section('custom_link_label_first', 'Mahasiswa')

@section('custom_link_second', route('signIn.admin'))

@section('custom_link_label_second', 'Admin')

@section('background_url', asset('img/lecturer-signin-hero.png'))

@section('bg-position-y', '80%')
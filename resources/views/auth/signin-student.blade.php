@extends('layouts.signIn-base')

@section('title', 'Log In Mahasiswa')

@section('form_action', route('signIn.user.authenticate'))

@section('custom_link_first', route('signIn.admin'))

@section('custom_link_label_first', 'Admin')

@section('custom_link_second', route('signIn.lecturer'))

@section('custom_link_label_second', 'Dosen')

@section('background_url', asset('img/student-signin-hero.jpg'))

@section('bg-position-y', '80%')
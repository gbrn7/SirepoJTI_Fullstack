@extends('layouts.signIn-base')

@section('title', 'SignIn as User')

@section('custom_link', route('signIn.admin'))

@section('custom_link_label', 'SignIn as Admin')

@section('background_url', asset('img/auth-user-hero.jpg'))

@section('bg-position-y', '80%')
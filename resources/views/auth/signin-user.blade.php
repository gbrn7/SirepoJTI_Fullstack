@extends('layouts.signIn-base')

@section('title', 'Log In as User')

@section('form_action', route('signIn.user.authenticate'))

@section('custom_link', route('signIn.admin'))

@section('custom_link_label', 'Log In as Admin')

@section('background_url', asset('img/auth-user-hero.jpg'))

@section('bg-position-y', '80%')
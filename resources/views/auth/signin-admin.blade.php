@extends('layouts.signIn-base')

@section('title', 'SignIn as Admin')

@section('custom_link', route('signIn.user'))

@section('custom_link_label', 'SignIn as User')

@section('background_url', asset('img/auth-admin-hero.jpg'))
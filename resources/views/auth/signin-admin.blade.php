@extends('layouts.signIn-base')

@section('title', 'Log In as Admin')

@section('form_action', route('signIn.user.authenticate', ['isAdmin' => true]))

@section('custom_link', route('signIn.user'))

@section('custom_link_label', 'Log In as User')

@section('background_url', asset('img/auth-admin-hero.jpg'))
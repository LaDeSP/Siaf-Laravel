@extends('layouts.admin-master')

@section('title')
Create User
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Add User</h1>
    </div>
    <div class="section-body">
        <div class="row d-flex justify-content-center">
            <!--<div class="alert alert-success alert-dismissible show fade col-10">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    This is a danger alert.
                </div>
            </div>-->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add a New User</h4>
                    </div>
                    <form class="needs-validation p-0 col-sm-8 col-md-8 col-lg-8 align-self-center" novalidate="">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Your Name</label>
                                <input type="text" class="form-control" required="">
                                <div class="invalid-feedback">
                                    What's your name?
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" required="">
                                <div class="invalid-feedback">
                                    Oh no! Email is invalid.
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="email" class="form-control">
                                <div class="valid-feedback">
                                    Good job!
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Message</label>
                                <textarea class="form-control" required=""></textarea>
                                <div class="invalid-feedback">
                                    What do you wanna say?
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

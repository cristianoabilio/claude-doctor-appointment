@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Profile</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <div class="align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ ($user->photo) ? url('upload/admin_images/' . $user->photo) : url('upload/no-image.jpg') }}" class="rounded-circle avatar-xxl img-thumbnail float-start" alt="image profile">

                                <div class="overflow-hidden ms-4">
                                    <h4 class="m-0 text-dark fs-20">{{ $user->name }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane pt-4" id="profile_setting" role="tabpanel">
                            <div class="row">

                                <div class="row">

                                    <div class="col-lg-6 col-xl-6">
                                        <form action="{{ route('admin.profile.update') }}"" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card border mb-0">

                                                <div class="card-header">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h4 class="card-title mb-0">Personal Information</h4>
                                                        </div><!--end col-->
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label">Name</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', $user->name)}}">
                                                        </div>
                                                    </div>


                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label" for="phone">Contact Phone</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                                                <input type="text" class="form-control @error('phone') is-invalid @enderror"  placeholder="Phone" aria-describedby="basic-addon1" id="phone" name="phone" value="{{old('phone', $user->phone)}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label" for="email">Email Address</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="input-group">
                                                                <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email)}} " placeholder="Email"  name="email">
                                                                @error('email')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3 row">
                                                        <label for="photo" class="form-label">Profile Image</label>
                                                        <div class="form-control-wrap">
                                                            <input type="file" class="form-control" id="image" name="photo">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3 row">
                                                        <label for="photo" class="form-label">Profile Image</label>
                                                        <div class="form-control-wrap">
                                                            <img id="showImage" src="{{ (! empty($user->photo))
                                                            ? url('upload/admin_images/' . $user->photo)
                                                            : url('upload/no-image.jpg') }}" class="rounded-circle avatar-xl img-thumbnail float-starts" width="80px" height="80px">
                                                        </div>
                                                    </div>

                                                    <div class="form-group mb-3 row">
                                                        <div class="form-control-wrap">
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div><!--end card-body-->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-6 col-xl-6">
                                        <form action="{{ route('admin.change-password') }}"" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card border mb-0">

                                                <div class="card-header">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <h4 class="card-title mb-0">Change Password</h4>
                                                        </div><!--end col-->
                                                    </div>
                                                </div>

                                                <div class="card-body mb-0">
                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label" for="old_password">Old Password</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <input class="form-control @error('old_password') is-invalid @enderror" type="password" id="old_password" name="old_password" placeholder="Old Password">
                                                            @error('old_password')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label" for="password">New Password</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <input class="form-control @error('password') is-invalid @enderror" type="password"  id="password" name="password" placeholder="New Password">
                                                            @error('password')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label" id="password_confirmation">Confirm Password</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                                            <button type="button" class="btn btn-danger">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div><!--end card-body-->
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div> <!-- end education -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- container-fluid -->
</div>
<!-- content -->


<script type="text/javascript">

    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>
@endsection

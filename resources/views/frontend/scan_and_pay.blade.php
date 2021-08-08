@extends('frontend.layouts.app')
@section('title', 'Scan and Pay')
    
@section('content')
    <div class="scan_and_pay">
        <div class="card shadow">
            <div class="card-body text-center">
                @include('frontend.layouts.flash')

                @if (session('scan-security'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{session('scan-security')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div>
                    <img src="{{asset('frontend/img/scan_and_pay.png')}}" alt="Scan" width="220px">
                </div>
                <p class="mb-2">Click button, put QR code in the frame and pay</p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#scanModal">Scan</button>
                
                <!--Scan Modal -->
                <div class="modal fade" id="scanModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Scan & Pay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <video id="scanner" width="100%" height="200px"></video>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script> --}}
    <script src="{{asset('frontend/js/instascan.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            let scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });
            scanner.addListener('scan', function (result) {
                if(result) {
                    scanner.stop();
                    $('#scanModal').modal('hide');
                    let to_phone = result;
                    window.location.replace(`scan-and-pay-form?to_phone=${to_phone}`);
                }
            });
            $('#scanModal').on('hidden.bs.modal', function (event) {
                scanner.stop();
            })
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    $('#scanModal').on('show.bs.modal', function (event) {
                        scanner.start(cameras[0]);
                    })
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
        });
    </script>
@endsection

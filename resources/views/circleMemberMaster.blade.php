<button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#circleMaster">
    Select Meeting Persons
</button>

<!-- Modal -->
<div class="modal fade" id="circleMaster" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-body ">

                <div class="row d-flex  justify-content-center ">
                    <div class="col-md-12 border-bottom pb-3">
                        <span class="button"></span>
                        {{-- <h2> Circles </h2> --}}
                        <div class="row row-cols-4 g-4 circleMemberCards">

                            <!-- Circle cards will be populated dynamically via JavaScript -->
                        </div>

                    </div>

                    <div class="col-md-12 p-3 ">
                        <div class="circleMembersList">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- script section --}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<link rel="stylesheet" href="{{ asset('css/circleMemberMaster.css') }}">
<script src="{{ asset('js/circleMemberMaster.js') }}"></script>

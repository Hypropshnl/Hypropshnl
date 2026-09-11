@extends(auth()->check() ? 'layouts.app' : 'layouts.public')

@section('content')
<section class="row">
    <div class="">
        <div class="row ">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header bg-primary text-white" style="padding: 20px; border-top-left-radius: 6px; border-top-right-radius: 6px;">
                        <h3 class="mt-0">Certificate Preview</h3>
                        <p class="mb-0">Your course certificate is ready. You can view it below and download a copy.</p>
                    </div>
                    <div class="body p-4">
                        <div class="mb-4 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between">
                            <div>
                                <h4 class="m-0">{{ optional($certificate->courseDetail)->name ?: 'Completed Course' }}</h4>
                                <p class="text-muted mb-0">Certificate reference: <strong>{{ $certificate->uid }}</strong></p>
                            </div>
                            <div class="mt-3 mt-sm-0">
                                <a href="{{ asset('files/certificates/'.$certificate->certificate_doc) }}" class="btn btn-success btn-lg mr-2" download>
                                    <i class="fa fa-download"></i> Download Certificate
                                </a>
                                <a href="{{ url()->previous() }}" class="btn btn-default btn-lg">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>

                        <div class="certificate-preview rounded shadow" style="background: #f7fafc; padding: 18px; border: 1px solid #e2e8f0;">
                            <img src="{{ asset('files/certificates/'.$certificate->certificate_doc) }}" alt="Certificate Preview" class="img-fluid" style="width: 100%; max-height: calc(100vh - 280px); object-fit: contain; border-radius: 12px;">
                        </div>

                        <div class="mt-4 p-4 rounded" style="background: #ffffff; border: 1px solid #e2e8f0;">
                            <h5 class="mb-3">Certificate Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Recipient:</strong>
                                    <p class="mb-0">
                                        @if($certificate->user_id)
                                            {{ trim(optional($certificate->userDetail)->firstname . ' ' . optional($certificate->userDetail)->othername . ' ' . optional($certificate->userDetail)->lastname) ?: 'Learner' }}
                                        @else
                                            {{ trim(optional($certificate->extUser)->firstname . ' ' . optional($certificate->extUser)->othername . ' ' . optional($certificate->extUser)->lastname) ?: 'Learner' }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Course:</strong>
                                    <p class="mb-0">{{ optional($certificate->courseDetail)->name ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Start Date:</strong>
                                    <p class="mb-0">{{ $certificate->start_date ?: 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>End Date:</strong>
                                    <p class="mb-0">{{ $certificate->end_date ?: 'N/A' }}</p>
                                </div>
                                @if(!empty($certificate->courseDetail) && !empty($certificate->courseDetail->certificate))
                                    <div class="col-md-6 mb-3">
                                        <strong>Certificate Status:</strong>
                                        <p class="mb-0">
                                            @if($certificate->courseDetail->certificate == 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <strong>View Link:</strong>
                                    <p class="mb-0"><a href="{{ url()->current() }}" class="text-primary">Open certificate page</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/partner.css') }}">
</head>

<body>
    <div class="layout">
        @include('include.adminSideBar')
        <div class="container">

            <h2 class="mb-4">{{ isset($editPartner) ? 'Edit' : 'Add' }} Partner</h2>

            <form method="POST" enctype="multipart/form-data"
                action="{{ isset($editPartner) ? route('partners.update', $editPartner->partnerID) : route('partners.store') }}">
                @csrf
                @if (isset($editPartner))
                    @method('PUT')
                @endif

                <input type="hidden" name="id" value="{{ $editPartner->partnerID ?? '' }}">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="Partner_name" class="form-control"
                        value="{{ $editPartner->Partner_name ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="Partner_description" class="form-control" required>{{ $editPartner->Partner_description ?? '' }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Picture</label>
                    <input type="file" name="picture" class="form-control">
                    @if (isset($editPartner) && $editPartner->picture)
                        <img src="{{ route('partner.image', basename($editPartner->picture)) }}" width="100"
                            class="mt-2 rounded">
                    @endif
                </div>

                <button class="btn btn-primary">{{ isset($editPartner) ? 'Update' : 'Add' }}</button>
                @if (isset($editPartner))
                    <a href="{{ route('admin.partners') }}" class="btn btn-secondary ms-2">Cancel</a>
                @endif
            </form>

            <hr>

            <h3 class="mt-4">All Partners</h3>
            @foreach ($partners as $partner)
                <div class="card mb-3 p-3 shadow rounded">
                    <div class="d-flex align-items-center">
                        @if ($partner->picture)
                            <img src="{{ route('partner.picture', basename($partner->picture)) }}" width="80"
                                class="me-3 rounded" alt="Partner Image">
                        @endif
                        <div>
                            <h5>{{ $partner->Partner_name }}</h5>
                            <p>{{ $partner->Partner_description }}</p>
                            <a href="{{ route('admin.partners', ['edit' => $partner->partnerID]) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('partners.destroy', $partner->partnerID) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <form action="{{ route('partners.destroy', $partner->partnerID) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this partner?')">Delete</button>
                                </form>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>

</body>

</html>

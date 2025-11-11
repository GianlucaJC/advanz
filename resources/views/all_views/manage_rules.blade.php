@extends('all_views.viewmaster.index_a')

@section('title', 'Gestione Regole di Ordinabilità')

@section('extra_style')
    {{-- Stili per select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: .25rem;
            padding: .375rem .75rem;
        }
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('content_main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestione Regole di Ordinabilità per Paese</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
                            </div>
                        @endif

                        <form action="{{ route('rules.update') }}" method="POST">
                            @csrf
                            <div class="accordion" id="accordionCountries">
                                @foreach ($countries as $countryId => $countryName)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $countryId }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $countryId }}" aria-expanded="false" aria-controls="collapse{{ $countryId }}">
                                                {{ $countryName }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $countryId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $countryId }}" data-bs-parent="#accordionCountries">
                                            <div class="accordion-body">
                                                {{-- Campo nascosto per forzare l'invio dell'array del paese anche se vuoto --}}
                                                <input type="hidden" name="rules[{{ $countryId }}]" value="">
                                                <div class="form-group">
                                                    <label for="rules_{{ $countryId }}">Prodotti ordinabili:</label>
                                                    <select class="form-control select2" name="rules[{{ $countryId }}][]" id="rules_{{ $countryId }}" multiple="multiple">
                                                        @foreach ($allestimenti as $allestimento)
                                                            <option value="{{ $allestimento->id }}"
                                                                @if (isset($rules[$countryId]) && in_array($allestimento->id, $rules[$countryId]))
                                                                    selected
                                                                @endif
                                                            >
                                                                {{ $allestimento->descrizione_completa }} (ID: {{ $allestimento->id }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Salva Regole</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_plugin')
    {{-- Script per select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Seleziona i prodotti ordinabili",
                allowClear: true
            });
        });
    </script>
@endsection
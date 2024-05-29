<style>
    .download-modal thead th{
        padding: 10px 0;
        font-weight: 600;
    }
    .download-modal tbody tr td{
        padding: 10px 5px;
    }
</style>
<div class="download-modal">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('all.files') }}</h1>
    </div>
            <div class="mt-4">
                <table class="table-auto" style="width: 100%; text-align: center; margin-top: 29px;">
                    <thead style="background: #00bcd429;">
                        <tr>
                            <th>{{ __('all.file_name') }}</th>
                            <th class="text-center">{{ __('all.completed_at') }}</th>
                            <th class="text-center">{{ __('all.successful_rows') }}</th>
                            <th class="text-center">{{ __('all.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exports as $export)
                            <tr>
                                <td>{{ $export->file_name }}</td>
                                <td>{{ $export->completed_at }}</td>
                                <td>{{ $export->processed_rows }}/{{ $export->total_rows }} {{ __('all.rows') }}</td>
                                <td>
                                    @if($export->successful_rows == $export->total_rows)
                                        <x-filament::button color="info" href="{{ route('download_excel', $export->id) }}" tag="a" icon="heroicon-o-cloud-arrow-down">
                                            {{ __('all.download') }}
                                        </x-filament::button>
                                    @else
                                        <x-filament::button color="danger" tag="a" icon="heroicon-o-clock">
                                            {{ __('all.waiting') }}
                                        </x-filament::button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @if ($exports->isEmpty())
                            <tr>
                                <td colspan="4">{{ __('all.no_files') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
</div>

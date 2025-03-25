@php use App\Enums\NewRoleEnum; @endphp
@php
    header('Content-Type: text/csv; charset=UTF-8');
@endphp
<table style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Name</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Mobile</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Advisor</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Advisor BC</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Broker</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Lives</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Status</th>
        <th style="text-align: center; padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Created</th>
    </tr>
    </thead>
    <tbody>
    @foreach($leads as $lead)

            <?php
            $advisorBc = $lead->lead?->assigned()?->whereHas('Agent', function ($q) {
                $q->whereHas('roles', function ($q) {
                    $q->where('name', 'LIKE', "%BC%");
                });
            })->first();

            ?>

        <tr>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->full_name }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->mobile }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->lead?->agent?->full_name }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $advisorBc?->agent?->full_name}}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->lead?->broker?->full_name }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->lead?->contract?->lives }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ $lead->lead?->Status?->name }}</td>
            <td style="text-align: center; padding: 8px; border: 1px solid #ddd;">{{ date('d-m-Y', strtotime($lead->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@component('mail::message')
# Reward Redeemed

Hello!

You have successfully redeemed the reward: **{{ $reward->name }}**.

@if($reward->description)
Description: {{ $reward->description }}
@endif

Points used: {{ $reward->point_cost }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

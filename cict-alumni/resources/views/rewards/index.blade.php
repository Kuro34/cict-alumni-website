@extends('layouts.alumni')

@section('content')
<style>
    .rewards-container { padding: 20px; }
    .points-summary { margin-bottom: 20px; font-size: 1.2rem; font-weight: 600; }
    .rewards-list { display: flex; flex-wrap: wrap; gap: 20px; }
    .reward-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 15px;
        width: 220px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .reward-card:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
    .reward-card img { width: 100%; height: 120px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
    .reward-card h3 { margin-bottom: 5px; font-size: 1.1rem; }
    .reward-card p { margin-bottom: 8px; font-size: 0.9rem; color: #555; }
    .redeem-button {
        padding: 8px 15px;
        border: none;
        background-color: #28a745;
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .redeem-button:disabled { background-color: #ccc; cursor: not-allowed; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.5); display: none;
        justify-content: center; align-items: center; z-index: 999;
    }
    .modal { background: #fff; width: 600px; max-width: 90%; border-radius: 12px; display: flex; overflow: hidden; }
    .modal-left { flex: 1; padding: 20px; background: #f8f8f8; display: flex; justify-content: center; align-items: center; }
    .modal-left img { max-width: 100%; border-radius: 10px; }
    .modal-right { flex: 1; padding: 20px; display: flex; flex-direction: column; }
    .modal-right h3 { margin-bottom: 10px; }
    .modal-right p { flex: 1; margin-bottom: 15px; color: #555; }
    .modal-buttons { display: flex; justify-content: flex-end; gap: 10px; }
    .modal-buttons button { padding: 8px 15px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
    .btn-back { background-color: #6c757d; color: #fff; }
    .btn-redeem { background-color: #28a745; color: #fff; }
</style>

<div class="rewards-container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <h1>Raffles & Rewards</h1>

    <div class="points-summary">
        <p>Your Points: {{ $totalPoints }}</p>
    </div>

    <div class="rewards-list">
        @foreach($rewards as $reward)
            @php
                $rewardImage = $reward->image 
                               ? asset('storage/' . ltrim($reward->image, '/')) 
                               : asset('images/default-reward.jpg');
            @endphp
            <div class="reward-card"
                 data-id="{{ $reward->rewardID }}"
                 data-name="{{ $reward->name }}"
                 data-description="{{ $reward->description ?? $reward->raffle->description ?? 'No description available' }}"
                 data-points="{{ $reward->point_cost }}"
                 data-image="{{ $rewardImage }}"
                 data-raffle="{{ $reward->raffleID ? 1 : 0 }}">
                <img src="{{ $rewardImage }}" alt="{{ $reward->name }}">
                <h3>{{ $reward->name }}</h3>
                <p>{{ $reward->description ?? $reward->raffle->description ?? 'No description available' }}</p>
                <p>Cost: {{ $reward->point_cost }} points</p>
                <button type="button" class="redeem-button"
                        @if($totalPoints < $reward->point_cost) disabled @endif>
                    @if($reward->raffleID) Enter Raffle @else Redeem @endif
                </button>
            </div>
        @endforeach
    </div>
</div>

{{-- Modal --}}
<div class="modal-overlay" id="rewardModal">
    <div class="modal">
        <div class="modal-left">
            <img id="modalImage" src="" alt="Reward Image">
        </div>
        <div class="modal-right">
            <h3 id="modalName"></h3>
            <p id="modalDescription"></p>
            <p><strong>Cost: </strong><span id="modalPoints"></span> points</p>
            <div class="modal-buttons">
                <button class="btn-back" id="modalBack">Back</button>
                <form method="POST" id="modalRedeemForm">
                    @csrf
                    <button type="submit" class="btn-redeem" id="modalRedeemBtn">Redeem</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const rewardCards = document.querySelectorAll('.reward-card');
    const modal = document.getElementById('rewardModal');
    const modalImage = document.getElementById('modalImage');
    const modalName = document.getElementById('modalName');
    const modalDescription = document.getElementById('modalDescription');
    const modalPoints = document.getElementById('modalPoints');
    const modalBack = document.getElementById('modalBack');
    const modalRedeemForm = document.getElementById('modalRedeemForm');
    const modalRedeemBtn = document.getElementById('modalRedeemBtn');

    rewardCards.forEach(card => {
        card.addEventListener('click', () => {
            const isRaffle = card.dataset.raffle == 1;

            modalImage.src = card.dataset.image;
            modalName.textContent = card.dataset.name;
            modalDescription.textContent = card.dataset.description;
            modalPoints.textContent = card.dataset.points;

            modalRedeemForm.action = `/rewards/redeem/${card.dataset.id}`;

            // Update button text dynamically
            modalRedeemBtn.textContent = isRaffle ? 'Enter Raffle' : 'Redeem';

            // Disable button if not enough points
            const userPoints = {{ $totalPoints }};
            const rewardPoints = parseInt(card.dataset.points);
            modalRedeemBtn.disabled = userPoints < rewardPoints;
            if (userPoints < rewardPoints) {
                modalRedeemBtn.textContent = 'Not enough points';
            }

            modal.style.display = 'flex';
        });
    });

    modalBack.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    modalRedeemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if(confirm('Are you sure you want to proceed?')) {
            this.submit();
        }
    });
</script>
@endsection

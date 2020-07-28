@extends('layouts.base')

@push('head')
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    @component('components.profile-mini', ['user' => Auth::user(), 'class' => 'mb-4'])
                    @endcomponent
                    @component('components.profile-stats', ['user' => Auth::user()])
                    @endcomponent
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">サイトからのお知らせ</div>
                <div class="list-group list-group-flush tis-sidebar-info">
                    @foreach($informations as $info)
                        <a class="list-group-item" href="{{ route('info.show', ['id' => $info->id]) }}">
                            @if ($info->pinned)
                                <span class="badge bg-secondary"><span class="oi oi-pin"></span>ピン留め</span>
                            @endif
                            <span class="badge {{ $categories[$info->category]['class'] }}">{{ $categories[$info->category]['label'] }}</span> {{ $info->title }} <small class="text-secondary">- {{ $info->created_at->format('n月j日') }}</small>
                        </a>
                    @endforeach
                    <a href="{{ route('info') }}" class="list-group-item text-right">お知らせ一覧 &raquo;</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            @if (!empty($globalEjaculationCounts))
                <h5>チェックインの動向</h5>
                <div class="w-100 mb-4 position-relative tis-global-count-graph">
                    <canvas id="global-count-graph"></canvas>
                </div>
            @endif
            @if (!empty($publicLinkedEjaculations))
                <h5 class="mb-3">お惣菜コーナー</h5>
                <p class="text-secondary">最近の公開チェックインから、オカズリンク付きのものを表示しています。</p>
                <ul class="list-group">
                    @foreach ($publicLinkedEjaculations as $ejaculation)
                        <li class="list-group-item no-side-border pt-3 pb-3 text-break">
                            @component('components.ejaculation', compact('ejaculation'))
                            @endcomponent
                        </li>
                    @endforeach
                    <li class="list-group-item no-side-border text-right">
                        <a href="{{ route('timeline.public', ['page' => 2]) }}" class="stretched-link">もっと見る &raquo;</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
    <script id="global-count-labels" type="application/json">@json(array_keys($globalEjaculationCounts))</script>
    <script id="global-count-data" type="application/json">@json(array_values($globalEjaculationCounts))</script>
    <script src="{{ mix('js/vendor/chart.js') }}"></script>
    <script src="{{ mix('js/home.js') }}"></script>
@endpush

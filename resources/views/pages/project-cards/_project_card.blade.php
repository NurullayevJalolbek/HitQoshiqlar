<div class="project-card" onclick="window.location.href='{{ route('admin.project-cards.show', $id) }}'">
    <div style="position: relative;">
        <img src="{{ $image }}" alt="{{ $name }}" class="project-image">
        <div class="risk-indicator risk-{{ $risk }}">
            @if($risk == 'past')
                {{__('admin.low_risk')}}
            @elseif($risk == 'orta')
                {{__('admin.medium_risk')}}
            @else
                {{__('admin.high_risk')}}
            @endif
        </div>
    </div>
    
    <div class="project-content">
        <h3 class="project-title">{{ $name }}</h3>
        <div class="project-location">
            <i class="fas fa-map-marker-alt"></i>
            {{ $location }}
        </div>
        
        <div class="project-stats">
            <div class="stat-item">
                <div class="stat-label">{{__('admin.min_investment')}}</div>
                <div class="stat-value">{{ $min_investment }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">{{__('admin.duration')}}</div>
                <div class="stat-value">{{ $duration }} {{__('admin.months')}}</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">{{__('admin.annual_return')}}</div>
                <div class="stat-value">{{ $annual_return }}%</div>
            </div>
            <div class="stat-item">
                <div class="stat-label">{{__('admin.status')}}</div>
                <div class="stat-value">
                    <span class="status-badge status-{{ $status }}">
                        @if($status == 'nofaol')
                            {{__('admin.inactive')}}
                        @elseif($status == 'rejalashtirilgan')
                            {{__('admin.planned')}}
                        @elseif($status == 'faol')
                            {{__('admin.active')}}
                        @else
                            {{__('admin.completed')}}
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <div class="project-footer">
            <span style="color: #718096; font-size: 0.85rem;">
                <i class="fas fa-eye"></i> {{__('admin.view_details')}}
            </span>
            <button class="view-details-btn">
                {{__('admin.learn_more')}}
            </button>
        </div>
    </div>
</div>
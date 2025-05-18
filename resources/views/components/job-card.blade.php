@props(['job'])
<div>
                       <div class="job-card bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition"
                       data-title="{{ strtolower($job->title) }}"
                       data-description="{{ strtolower($job->description) }}"
                       data-location="{{ strtolower($job->location) }}                   
                    ">
                        <div class="p-6 job-card-content">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                                @php
                                    $daysAgo = intval(\Carbon\Carbon::parse($job->posting_date)->diffInDays(now()));
                                @endphp
                              <span class="text-sm text-gray-500">
                                   {{ $daysAgo === 0 ? 'Today' : ($daysAgo === 1 ? '1 day ago' : $daysAgo . ' days ago') }}
                                </span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $job->location }}</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $job->description}}</p>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span>Your skills match:</span>
                                    <span>{{ $job->match_count }}/{{ $job->total_skills }} skills</span>
                                </div>
                                <div class="skill-progress">
                                    <div class="skill-progress-fill" style="width: {{ $job->match_percent }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-footer p-6 pt-0 border-t border-gray-100 flex justify-between items-center">
                            
                     <button 
    class="view-details text-primary hover:text-primary-dark font-medium"
    data-title="{{ $job->title }}"
    data-location="{{ $job->location }}"
    data-description="{{ $job->details }}"
    data-method="{{ $job->application_method }}"
    data-company="{{ $job->company_name }}"
    data-deadline="{{ $job->application_deadline }}"
    data-width="{{ $job->match_percent }}%"
    data-skills="{{ $job->match_count }}/{{ $job->total_skills }} skills"
>
    View Details
</button>

                            <form method="POST" action="{{ route('jobs.save',  $job->jobID) }}">
                              @csrf
                            <button  type="submit" onclick="showToast()" class="text-secondary hover:text-secondary-dark flex items-center gap-1">
                                <i class="far fa-star"></i>
                                <span>Save</span>
                            </button>
                            </form>
                        </div>
                    </div>
                    
</div>

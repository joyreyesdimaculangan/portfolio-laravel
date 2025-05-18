<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $personalInfo['name'] ?? 'My Resume' }} - Resume</title>
    <style>
        @page {
            margin: 0.5cm 1cm;
        }
        body {
            font-family: {{ $styling['font_family'] }}, sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 11pt;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
        .name {
            font-size: 22pt;
            font-weight: bold;
            color: {{ $styling['accent_color'] }};
            margin-bottom: 5px;
        }
        .contact-info {
            font-size: 10pt;
        }
        .section {
            margin-bottom: 15px;
        }
        h2 {
            color: {{ $styling['accent_color'] }};
            font-size: 14pt;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .item {
            margin-bottom: 12px;
        }
        .item-header {
            display: flex;
            justify-content: space-between;
        }
        .item-title {
            font-weight: bold;
        }
        .item-subtitle {
            font-style: italic;
        }
        .item-date {
            color: #666;
            font-size: 10pt;
        }
        .item-description {
            font-size: 10pt;
            margin-top: 5px;
        }
        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 8px;
        }
        .skill-item {
            background: #f3f3f3;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10pt;
        }
        .columns {
            display: flex;
            gap: 20px;
        }
        .column {
            flex: 1;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="name">{{ $personalInfo['name'] ?? 'Your Name' }}</div>
        <div class="contact-info">
            {{ $personalInfo['email'] ?? '' }} 
            @if(isset($personalInfo['phone']))
            | {{ $personalInfo['phone'] }}
            @endif
            @if(isset($personalInfo['location']))
            | {{ $personalInfo['location'] }}
            @endif
        </div>
        <div class="contact-info">
            @if(isset($personalInfo['linkedin_url']))
                LinkedIn: {{ $personalInfo['linkedin_url'] }}
            @endif
            @if(isset($personalInfo['github_url']))
                | GitHub: {{ $personalInfo['github_url'] }}
            @endif
            @if(isset($personalInfo['portfolio_url']))
                | Portfolio: {{ $personalInfo['portfolio_url'] }}
            @endif
        </div>
    </div>
    
    @if(isset($personalInfo['resume_objective']) && in_array('objective', $sections))
    <div class="section">
        <h2>About Me</h2>
        <div>{{ $personalInfo['resume_objective'] }}</div>
    </div>
    @endif

    @if(count($education) > 0 && in_array('education', $sections))
    <div class="section">
        <h2>Education</h2>
        @foreach($education as $edu)
            <div class="item">
                <div class="item-header">
                    <div>
                        <div class="item-title">{{ $edu->degree }}</div>
                        <div class="item-subtitle">{{ $edu->institution }}</div>
                    </div>
                    <div class="item-date">
                        {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - 
                        {{ $edu->current ? 'Present' : \Carbon\Carbon::parse($edu->end_date)->format('Y') }}
                    </div>
                </div>
                @if($edu->description)
                    <div class="item-description">{{ $edu->description }}</div>
                @endif
            </div>
        @endforeach
    </div>
    @endif
    
    @if(count($experiences) > 0 && in_array('experience', $sections))
    <div class="section">
        <h2>Experiences</h2>
        @foreach($experiences as $experience)
            <div class="item">
                <div class="item-header">
                    <div>
                        <div class="item-title">{{ $experience->title }}</div>
                        <div class="item-subtitle">{{ $experience->company }}</div>
                    </div>
                    <div class="item-date">
                        {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                        {{ $experience->current ? 'Present' : \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                    </div>
                </div>
                <div class="item-description">{{ $experience->description }}</div>
            </div>
        @endforeach
    </div>
    @endif
    
    @if(count($skillsByCategory) > 0 && in_array('skills', $sections))
    <div class="section">
        <h2>Skills</h2>
        @foreach($skillsByCategory as $category => $skills)
            <div class="item">
                @if($skillsByCategory->count() > 1)
                <div class="item-title">{{ $category }}</div>
                @endif
                <div class="skills-list">
                    @foreach($skills as $skill)
                        <span class="skill-item">{{ $skill->name }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif
    
    @if(count($certificates) > 0 && in_array('certificates', $sections))
    <div class="section">
        <h2>Certifications</h2>
        @foreach($certificates as $certificate)
            <div class="item">
                <div class="item-header">
                    <div>
                        <div class="item-title">{{ $certificate->name }}</div>
                        <div class="item-subtitle">{{ $certificate->issuer }}</div>
                    </div>
                    <div class="item-date">
                        {{ \Carbon\Carbon::parse($certificate->issue_date)->format('M Y') }}
                        @if($certificate->expiry_date)
                        - {{ \Carbon\Carbon::parse($certificate->expiry_date)->format('M Y') }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    
    @if(count($projects) > 0 && in_array('projects', $sections))
    <div class="section">
        <h2>Selected Projects</h2>
        @foreach($projects as $project)
            <div class="item">
                <div class="item-title">{{ $project->title }}</div>
                <div class="item-description">{{ $project->short_description }}</div>
                @if(isset($project->skills) && $project->skills->count() > 0)
                <div class="skills-list">
                    @foreach($project->skills as $skill)
                        <span class="skill-item">{{ $skill->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        @endforeach
    </div>
    @endif
</body>
</html>
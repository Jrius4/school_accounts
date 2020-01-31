@if(session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@elseif(session('error-message'))
    <div class="alert alert-danger">
        {{ session('error-message') }}
    </div>
@elseif(session('trash-message'))
    <?php list($message, $postId) = session('trash-message') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.blog.restore', $postId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('trash-message-service'))
    <?php list($message, $serviceId) = session('trash-message-service') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.services.restore', $serviceId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}

@elseif(session('trash-message-project'))
    <?php list($message, $projectId) = session('trash-message-project') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.projects.restore', $projectId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('trash-message-career'))
    <?php list($message, $careerId) = session('trash-message-career') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.careers.restore', $careerId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('trash-message-testimony'))
    <?php list($message, $testimonyId) = session('trash-message-testimony') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.client-testimonies.restore', $testimonyId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('trash-message-process'))
    <?php list($message, $processId) = session('trash-message-process') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.system-processes.restore', $processId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}

@elseif(session('trash-message-industry'))
    <?php list($message, $industryId) = session('trash-message-industry') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.field-industries.restore', $industryId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@elseif(session('trash-message-client'))
    <?php list($message, $clientId) = session('trash-message-client') ?>
    {!! Form::open(['method' => 'PUT', 'route' => ['backend.project-clients.restore', $clientId]]) !!}
        <div class="alert alert-info">
            {{ $message }}
            <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Undo</button>
        </div>
    {!! Form::close() !!}
@endif

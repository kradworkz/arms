@extends('layouts.backend.chatbox')
@section('content')
<div class="d-lg-flex">

    <div class="chat-leftsidebar mr-lg-4">
        <div class="">
            <div class="py-4 border-bottom">
                <div class="media">
                    <div class="align-self-center mr-3">
                        <img  src="{{asset('images/avatars/lgu.png')}}" class="avatar-md rounded-circle" alt="">
                    </div>
                  
                    <div class="media-body">
                        <h5 class="font-size-15 mt-0 mb-1">asdada</h5>
                        <p class="text-muted mb-0"><i class="icofont icofont-check-circled text-success align-middle mr-1"></i>asdadada</p>
                    </div>
                </div>
            </div> 
            <div class="search-box chat-search-box py-4">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search...">
                <i class="bx bx-search-alt search-icon"></i>
                </div>
            </div>

            <div class="chat-leftsidebar-nav">
                <div class="mt-4">
                    <div class="card border shadow-none mb-2">
                        <a href="javascript: void(0);" class="text-body">
                            <div class="p-2">
                                <div class="d-flex">
                                    <div class="avatar-xs align-self-center mr-2">
                                        <div class="avatar-title rounded bg-transparent text-success font-size-20">
                                                <i class='bx bxs-category'></i>
                                        </div>
                                    </div>

                                    <div class="overflow-hidden mr-auto">
                                        <h5 class="font-size-13 text-truncate mb-1">Vehicles</h5>
                                        <p class="text-muted text-truncate mb-0">176 Assets</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>           
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 user-chat">
        <div class="card">
            <div class="chat-conversation p-3" style="height: calc(100vh - 50px);">
                
            </div>
        </div>
    </div>
</div>

@endsection

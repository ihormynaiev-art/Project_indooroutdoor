<!-- Chat User List -->
<div class="col-lg-5 col-xl-3 chat-cont-left">
    <div class="card mb-sm-3 mb-md-0 contacts_card flex-fill">
        <div class="chat-header">
            <div>
                <h6>Chats</h6>
                <p>Start New Conversation</p>
            </div>
            <a href="javascript:void(0)" class="chat-compose">
                <i class="feather-plus"></i>
            </a>
        </div>
        <div class="chat-search">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="search_btn"><i class="feather-search"></i></span>
                </div>
                <input type="text" placeholder="Search messages or users" class="form-control search-chat">
            </div>
        </div>
        <ul class="chat-list">
            <li>
                <a href="javascript:void(0);" class="active"><i class="feather-message-square"></i> Chat</a>
            </li>
            <li>
                <a href="javascript:void(0);"><i class="feather-phone-call"></i> Call</a>
            </li>
            <li>
                <a href="javascript:void(0);"><i class="feather-users"></i> Contacts</a>
            </li>
        </ul>
        <div class="card-body contacts_body chat-users-list chat-scroll">
            <div class="chat-header inner-chat-header pt-0">
                <div>
                    <h6>Favourite</h6>
                </div>
                <a href="javascript:void(0)" class="chat-compose">
                    <i class="feather-plus"></i>
                </a>
            </div>
            <a href="javascript:void(0);" class="media d-flex active">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar avatar-online">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">John Steven</div>
                        <div class="user-last-chat">Lorem ipsum dolor</div>
                    </div>
                    <div>
                        <div class="last-chat-time">10:12 AM</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media d-flex read-chat">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar avatar-online">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-03.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">John Smith</div>
                        <div class="user-last-chat"><i class="feather-image"></i> Image</div>
                    </div>
                    <div>
                        <div class="last-chat-time">10:19 AM</div>
                        <div class="badge badge-primary badge-pill">2</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media d-flex">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-04.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">Audrey</div>
                        <div class="user-last-chat"><i class="feather-video"></i> Video</div>
                    </div>
                    <div>
                        <div class="last-chat-time">7:30 PM</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media read-chat d-flex">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar avatar-away">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-06.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">David</div>
                        <div class="user-last-chat"><i class="feather-file-text"></i> Document</div>
                    </div>
                    <div>
                        <div class="last-chat-time">6:59 PM</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media read-chat d-flex">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar avatar-online">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-05.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">Ashley</div>
                        <div class="user-last-chat">typing...</div>
                    </div>
                    <div>
                        <div class="last-chat-time">11:21 AM</div>
                    </div>
                </div>
            </a>
            <div class="chat-header inner-chat-header">
                <div>
                    <h6>Direct Messages</h6>
                </div>
                <a href="javascript:void(0)" class="chat-compose">
                    <i class="feather-plus"></i>
                </a>
            </div>
            <a href="javascript:void(0);" class="media d-flex">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-09.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">James</div>
                        <div class="user-last-chat">Lorem ipsum dolor</div>
                    </div>
                    <div>
                        <div class="last-chat-time">10:12 AM</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media d-flex read-chat">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar avatar-online">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-08.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">Sheila</div>
                        <div class="user-last-chat"><i class="feather-image"></i> Image</div>
                    </div>
                    <div>
                        <div class="last-chat-time">10:19 AM</div>
                        <div class="badge badge-primary badge-pill">2</div>
                    </div>
                </div>
            </a>
            <a href="javascript:void(0);" class="media d-flex">
                <div class="media-img-wrap flex-shrink-0">
                    <div class="avatar">
                        <img src="{{ URL::asset('/assets/img/profiles/avatar-10.jpg') }}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                </div>
                <div class="media-body flex-grow-1">
                    <div>
                        <div class="user-name">Eric</div>
                        <div class="user-last-chat"><i class="feather-video"></i> Video</div>
                    </div>
                    <div>
                        <div class="last-chat-time">7:30 PM</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Chat User List -->

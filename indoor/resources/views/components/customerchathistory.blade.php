<div class="card chat-window mb-0">
    <div class="card-header msg_head">
        <div class="d-flex bd-highlight">
            <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div class="img_cont">
                <img class="rounded-circle user_img" src="{{ URL::asset('/assets/img/profiles/chat-profile-01.jpg') }}"
                    alt="User">
            </div>
            <div class="user_info">
                <span>Hendrita</span>
                <p class="mb-0 active">Online</p>
            </div>
        </div>
        <div class="chat-options">
            <ul>
                <li><a href="javascript:;"><i class="feather-volume-2"></i></a></li>
                <li><a href="javascript:;"><i class="feather-search"></i></a></li>
                <li><a href="javascript:;"><i class="feather-video"></i></a></li>
                <li><a href="javascript:;" class="chat-profile-open"><i class="feather-user" id="task_chat"></i></a>
                </li>
                <li><a href="javascript:;" class="with-bg"><i class="feather-more-horizontal"></i></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="card-body msg_card_body chat-scroll pt-0">
        <ul class="list-unstyled">
            <li class="chat-date mt-0"><span>Yesterday</span></li>
            <li class="media received d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/chat-profile-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, incididunt
                                ut labore et dolore magna aliqua. </p>
                        </div>
                        <span class="drop-item message-more-option">
                            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <small class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;"><i class="feather-copy me-2"></i>Copy</a>
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-trash-2 me-2"></i>Delete</a>
                            </small>
                        </span>
                        <ul class="chat-msg-info name-date">
                            <li>Hendrita</li>
                            <li>
                                <span class="chat-time">09:30 am<i class="fa-solid fa-check-double read"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="media received d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/chat-profile-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div class="msg-img">
                            <div class="chat-msg-attachments">
                                <div class="chat-attachment">
                                    <img src="{{ URL::asset('/assets/img/chat-img-01.jpg') }}" alt="Attachment">
                                    <a href="" class="chat-attach-download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div class="chat-attachment">
                                    <img src="{{ URL::asset('/assets/img/chat-img-02.jpg') }}" alt="Attachment">
                                    <a href="" class="chat-attach-download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <span class="drop-item message-more-option">
                            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <small class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;"><i class="feather-copy me-2"></i>Copy</a>
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-trash-2 me-2"></i>Delete</a>
                            </small>
                        </span>
                        <ul class="chat-msg-info name-date">
                            <li>Hendrita</li>
                            <li>
                                <span class="chat-time">09:30 am<i class="fa-solid fa-check-double un-read"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="media sent d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/chat-profile-02.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <p>Sed ut perspiciatis unde omnis iste natus error accusantium
                                doloremque laudantium</p>
                        </div>
                        <span class="drop-item message-more-option">
                            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <small class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-copy me-2"></i>Copy</a>
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-trash-2 me-2"></i>Delete</a>
                            </small>
                        </span>
                        <ul class="chat-msg-info name-date">
                            <li>
                                <span class="chat-time">10:45 am<i class="fa-solid fa-check"></i></span>
                            </li>
                            <li>John Steven</li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="chat-date"><span>Today</span></li>
            <li class="media received d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/chat-profile-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, incididunt
                                ut labore et dolore magna aliqua. </p>
                        </div>
                        <span class="drop-item message-more-option">
                            <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <small class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-copy me-2"></i>Copy</a>
                                <a class="dropdown-item" href="javascript:;"><i
                                        class="feather-trash-2 me-2"></i>Delete</a>
                            </small>
                        </span>
                        <ul class="chat-msg-info name-date">
                            <li>Hendrita</li>
                            <li>
                                <span class="chat-time">09:30 am<i class="fa-solid fa-check-double read"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>

    </div>

    <div class="card-footer">
        <div class="input-group">
            <div class="btn-file btn">
                <i class="feather-plus"></i>
                <input type="file">
            </div>
            <input class="form-control type_msg mh-auto empty_check" placeholder="Write your message...">
            <div class="send-action">
                <a href="javascript:void(0);"><i class="fa-solid fa-face-smile"></i></a>
                <a href="javascript:void(0);"><i class="feather-mic"></i></a>
                <button class="btn btn-primary btn_send"><i class="fa fa-paper-plane"
                        aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>

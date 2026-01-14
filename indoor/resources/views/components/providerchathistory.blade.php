<!-- Chat History -->
<div class="card mb-0">

    <div class="card-header msg_head">
        <div class="d-flex bd-highlight">
            <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                <i class="fas fa-chevron-left"></i>
            </a>
            <div class="img_cont">
                <img class="rounded-circle user_img" src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}"
                    alt="User">
            </div>
            <div class="user_info">
                <span>John Steven</span>
                <p class="mb-0 active">Online</p>
            </div>
        </div>
        <div class="chat-options">
            <ul>
                <li><a href="javascript:;"><i class="feather-volume-2"></i></a></li>
                <li><a href="javascript:;"><i class="feather-search"></i></a></li>
                <li><a href="javascript:;"><i class="feather-video"></i></a></li>
                <li><a href="javascript:;"><i class="feather-user" id="task_chat"></i></a></li>
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
                    <img src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Steven</li>
                                <li>
                                    <span class="chat-time">8:55 PM</span>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i class="feather-trash-2"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, incididunt ut
                                labore et dolore magna aliqua. </p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="media sent d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/provider/provider-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Smith</li>
                                <li>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i class="feather-trash-2"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                    <span class="chat-time">8:55 PM</span>
                                </li>
                            </ul>
                            <p>Sed ut perspiciatis unde omnis iste natus error accusantium doloremque
                                laudantium</p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="media received d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Steven</li>
                                <li>
                                    <span class="chat-time">8:55 PM</span>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i class="feather-trash-2"></i>
                                                Delete</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="chat-msg-attachments">
                                <div class="chat-attachment">
                                    <img src="{{ URL::asset('/assets/img/services/service-03.jpg') }}" alt="Attachment">
                                    <a href="" class="chat-attach-download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                                <div class="chat-attachment">
                                    <img src="{{ URL::asset('/assets/img/services/service-04.jpg') }}" alt="Attachment">
                                    <a href="" class="chat-attach-download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="media sent d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/provider/provider-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Smith</li>
                                <li>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i
                                                    class="feather-trash-2"></i> Delete</a>
                                        </div>
                                    </div>
                                    <span class="chat-time">8:55 PM</span>
                                </li>
                            </ul>
                            <div class="chat-file-attachments">
                                <div class="chat-file-attach">
                                    <div class="chat-file-icon">
                                        <i class="feather-file-text"></i>
                                    </div>
                                    <div class="chat-file-info">
                                        <h6>admin_v1.0.zip</h6>
                                        <p>25mb Seprate file</p>
                                    </div>
                                </div>
                                <a href="" class="chat-file-download">
                                    <i class="feather-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="media received d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/profiles/avatar-02.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Steven</li>
                                <li>
                                    <span class="chat-time">8:55 PM</span>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i
                                                    class="feather-trash-2"></i> Delete</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <p>You wait for notice.</p>
                            <p>Consectetuorem ipsum dolor sit?</p>
                            <p>Ok?</p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="chat-date"><span>Today</span></li>
            <li class="media sent d-flex">
                <div class="avatar flex-shrink-0">
                    <img src="{{ URL::asset('/assets/img/provider/provider-01.jpg') }}" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="media-body flex-grow-1">
                    <div class="msg-box">
                        <div>
                            <ul class="chat-msg-info">
                                <li>John Smith</li>
                                <li>
                                    <div class="drop-item">
                                        <a href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="feather-more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:;"><i
                                                    class="feather-trash-2"></i> Delete</a>
                                        </div>
                                    </div>
                                    <span class="chat-time">8:55 PM</span>
                                </li>
                            </ul>
                            <div class="msg-highlight">
                                <a href="javascript:void(0);">Sed ut perspiciatis unde omnis iste natus
                                    error accusantium doloremque laudantium</a>
                            </div>
                        </div>
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

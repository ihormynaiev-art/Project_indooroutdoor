<!-- Chat Profile -->
<div class="chat-cont-profile chat-profile-right" id="task_window">
    <div class="card mb-sm-3 mb-md-0 flex-fill">
        <div class="card-header">
            <div class="profile-wrap">
                <div class="chat-profile">
                    <a id="back_user_lists" href="javascript:void(0)" class="back-user-list">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="chat-profile-img">
                        <img src="{{ URL::asset('/assets/img/profiles/chat-profile-01.jpg') }}" alt="User">
                    </div>
                    <div class="chat-profile-info">
                        <h6>Hendrita</h6>
                        <p>Newyork</p>
                    </div>
                </div>
                <ul>
                    <li>
                        <a href="javascript:void(0);"><i class="feather-mail"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="feather-phone"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="feather-map-pin"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="chat-pro-list">
                <ul>
                    <li>
                        <span class="role-title"><i class="fa-solid fa-briefcase"></i>Company</span><span
                            class="role-info">Company Name</span>
                    </li>
                    <li>
                        <span class="role-title"><i class="fa-solid fa-user"></i>Role</span><span
                            class="role-info">Co-founder</span>
                    </li>
                    <li>
                        <span class="role-title"><i class="fa-solid fa-phone"></i>Phone</span><span class="role-info">+1
                            123 456 7890</span>
                    </li>
                    <li>
                        <span class="role-title"><i class="fa-solid fa-envelope"></i>Email</span><span
                            class="role-info">info@johnsteven.com</span>
                    </li>
                </ul>
            </div>
            <div class="chat-media">
                <div class="chat-media-title">
                    <h6>Shared Media</h6>
                    <span>(3475 items)</span>
                </div>
                <div class="media-list">
                    <ul class="nav">
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#chat-photo"
                                class="active">Photos</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#chat-file">File</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#chat-vdo">Video</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="tab" data-bs-target="#chat-link">Link</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content pt-0">
                    <div class="tab-pane active" id="chat-photo">
                        <div class="photo-list">
                            <ul>
                                <li>
                                    <img src="{{ URL::asset('/assets/img/services/service-03.jpg') }}" alt="img">
                                </li>
                                <li>
                                    <img src="{{ URL::asset('/assets/img/services/service-04.jpg') }}" alt="img">
                                </li>
                                <li>
                                    <img src="{{ URL::asset('/assets/img/services/service-05.jpg') }}" alt="img">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="chat-vdo">
                        <div class="photo-list">
                            <ul>
                                <li>
                                    <img src="{{ URL::asset('/assets/img/services/service-01.jpg') }}" alt="img">
                                </li>
                                <li>
                                    <img src="{{ URL::asset('/assets/img/services/service-04.jpg') }}" alt="img">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="chat-file">
                        <div class="photo-file">
                            <ul>
                                <li>
                                    <i class="feather-file-text me-2"></i> admin_v1.0.zip
                                </li>
                                <li>
                                    <i class="feather-file-text me-2"></i> test.pdf
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="chat-link">
                        <div class="photo-link">
                            <ul>
                                <li>
                                    <a href="javascript:;"><i class="feather-link-2 me-2"></i> Sed ut
                                        perspiciatis</a>
                                </li>
                                <li>
                                    <a href="javascript:;"><i class="feather-link-2 me-2"></i>
                                        https:example.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="chat-notification">
                    <ul>
                        <li>
                            <p><i class="fa-solid fa-bell"></i> Notifications</p>
                            <div class="status-toggle blue-tog d-flex justify-content-sm-end align-items-center">
                                <input type="checkbox" id="status_1" class="check" checked="">
                                <label for="status_1" class="checktoggle">checkbox</label>
                            </div>
                        </li>
                        <li>
                            <p><i class="fa-solid fa-star"></i> Add To Favourites</p>
                            <div class="status-toggle blue-tog d-flex justify-content-sm-end align-items-center">
                                <input type="checkbox" id="status_2" class="check" checked="">
                                <label for="status_2" class="checktoggle">checkbox</label>
                            </div>
                        </li>
                        <li>
                            <p><i class="fa-solid fa-volume-xmark"></i> Mute</p>
                            <div class="status-toggle blue-tog d-flex justify-content-sm-end align-items-center">
                                <input type="checkbox" id="status_3" class="check">
                                <label for="status_3" class="checktoggle">checkbox</label>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clear-list">
                    <ul>
                        <li><a href="javascript:;"><i class="feather-trash-2"></i>Clear Chat</a></li>
                        <li><a href="javascript:;"><i class="feather-external-link"></i>Export Chat</a>
                        </li>
                        <li><a href="javascript:;"><i class="feather-alert-circle"></i>Report
                                Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Chat Content -->

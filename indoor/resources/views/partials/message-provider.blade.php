<div class="modal modal-lg fade custom-modal" id="message-to-provider">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content doctor-profile">
            <div class="modal-header border-bottom-0 justify-content-between pb-2">
                <h5 class="modal-title">SEND MESSAGE TO THE PROVIDER</h5>
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                        class="feather-x"></i></button>
            </div>
            <div class="modal-body pt-0">
                <form id="message-form" onsubmit="return false;" action="{{ route('provider.provider-messages.store') }}"
                      method="post">
                    @csrf
                    <input type="hidden" name="provider_id" id="provider_id" value="{{ $providerDetail->id }}">
                    @auth
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    @endauth
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Your Contact Info</label>
                                <input required name="contact" type="text" class="form-control"
                                       placeholder="Type your email or phone number" id="contact-input">
                                <span class="validation-error" id="contact-error"></span>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label">Your Question</label>
                                    <textarea required rows="6" type="text" name="message"
                                              class="form-control"
                                              placeholder="Can you help with my job?"
                                              id="message-input"
                                    ></textarea>
                                    <span class="validation-error" id="message-error"></span>
                                </div>
                            </div>
                            <x-file-upload-preview
                                inputId="documents-msg"
                                previewClass="documents-preview-msg"
                                uploadBtnId="upload-btn-msg"
                                errorId="documents-error-msg"
                                variableName="managedFilesMsg"
                                accept="image/*"
                                fileRequirements="Allowed: JPG, PNG, WEBP<br>Max size: 5MB"
                            />
                            <div class="d-flex justify-content-center">
                                <button class="site-button site-button-secondary">Send Message to Provider</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const formMsg = document.getElementById("message-form");
            const contactInput = document.getElementById("contact-input");
            const contactError = document.getElementById("contact-error");
            const messageInput = document.getElementById("message-input");
            const messageError = document.getElementById("message-error");

            if (contactInput && contactError) {
                contactInput.addEventListener("input", function () {
                    const value = this.value;

                    if (value.length > 100) {
                        contactError.innerHTML = "Contact info must not exceed 100 characters.";
                    } else {
                        contactError.innerHTML = "";
                    }
                });
            }

            if (messageInput && messageError) {
                messageInput.addEventListener("input", function () {
                    const value = this.value;

                    if (value.length > 4000) {
                        console.log('error', messageError)
                        messageError.innerHTML = "Message must not exceed 4000 characters.";
                    } else {
                        messageError.innerHTML = "";
                    }
                });
            }

            // Form submission
            formMsg.addEventListener("submit", async function (e) {
                e.preventDefault();

                // Валидация поля contact
                const contactInput = document.getElementById("contact-input");
                const contactValue = contactInput.value.trim();

                if (!contactValue) {
                    document.getElementById("contact-error").innerHTML = "Contact info is required.";
                    return;
                }

                if (contactValue.length > 100) {
                    document.getElementById("contact-error").innerHTML = "Contact info must not exceed 100 characters.";
                    return;
                }

                // Валидация поля message
                const messageInput = document.getElementById("message-input");
                const messageValue = messageInput.value.trim();

                if (!messageValue) {
                    document.getElementById("message-error").innerHTML = "Message is required.";
                    return;
                }

                if (messageValue.length > 4000) {
                    document.getElementById("message-error").innerHTML = "Message must not exceed 4000 characters.";
                    return;
                }

                const formData = new FormData(formMsg);

                // Убираем старое поле documents[]
                formData.delete("documents[]");

                // Добавляем свои файлы
                if (window.managedFilesMsg && window.managedFilesMsg.length > 0) {
                    window.managedFilesMsg.forEach(file => {
                        formData.append("documents[]", file);
                    });
                }

                try {
                    const response = await fetch(formMsg.action, {
                        method: "POST",
                        body: formData,
                    });

                    if (response.ok) {
                        Swal.fire({
                            title: "Message Sent!",
                            html: "Your message has been successfully sent to the provider.",
                            icon: "success"
                        });

                        formMsg.reset();
                        if (typeof window.clearFiles_managedFilesMsg === 'function') {
                            window.clearFiles_managedFilesMsg();
                        }

                        document.getElementById("message-to-provider").querySelector(".close-btn").click();
                        return;
                    }

                    // Ошибки 422
                    if (response.status === 422) {
                        // Очищаем ошибки перед установкой новых
                        document.getElementById("contact-error").innerHTML = "";
                        document.getElementById("message-error").innerHTML = "";
                        document.getElementById("documents-error-msg").innerHTML = "";

                        const data = await response.json();
                        const errors = data.errors;

                        for (let key in errors) {
                            if (key.startsWith("documents.")) {
                                document.getElementById("documents-error-msg").innerHTML = errors[key][0];
                            } else if (document.getElementById(key + "-error")) {
                                document.getElementById(key + "-error").innerHTML = errors[key][0];
                            }
                        }
                    }

                } catch (error) {
                    console.error("Error submitting:", error);
                }

            });

        });
    </script>


if($.fn.dataTable.isDataTable("#contact-messages-data"))n=$("#contact-messages-data").DataTable();else var n=$("#contact-messages-data").DataTable({ordering:!0,order:[4,"desc"],ajax:"contactMessages",columnDefs:[{width:"40%",targets:3}],columns:[{data:"name",name:"name"},{data:"email",name:"email"},{data:"phone"},{data:"message"},{data:"created_at"},{data:"id",orderable:!1,render:function(a,t,e){var s=`
                    <div class="action-language">
                        <a
                            data-email="${e.email}"
                            class="table-show"
                            href="javascript:void(0);"
                            data-bs-toggle="modal"
                            data-bs-target="#add-reply"
                        >
                                <i class="fa-regular fa-pen-to-square"></i>
                            <span>Reply</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${a}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return s}}],paging:!0,searching:!0,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var a=$(this).data("id");Swal.fire({title:"Delete Messages",text:"Are you sure want to delete?",showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(t=>{t.isConfirmed&&$.ajax({type:"DELETE",url:"/admin/contactMessages/"+a+"/",data:{_method:"DELETE",_token:$("#token").val()},success:function(e){e.status==="success"&&n.ajax.reload()}})})});$("#add-reply").on("show.bs.modal",function(a){var t=$(a.relatedTarget),e=t.data("email"),s=$(this);s.find("#email").val(e)});$("#reply-form").on("submit",function(a){a.preventDefault(),$('input[name="text"]').val(editor.getData()),editor.setData("");var t=$(this),e=t.serialize();$.ajax({url:"/admin/contactMessages/reply",method:"POST",data:e,success:function(s){$("#add-reply").modal("hide"),Swal.fire({toast:!0,icon:"success",title:"Send successfully",animation:!1,position:"top-right",showConfirmButton:!1,timer:3e3,timerProgressBar:!0,didOpen:o=>{o.addEventListener("mouseenter",Swal.stopTimer),o.addEventListener("mouseleave",Swal.resumeTimer)}})},error:function(s,o,i){$("#add-reply").modal("hide")}})});$(document).ready(function(){$("#nameFilter").on("keyup change",function(){n.column(0).search(this.value).draw()}),$("#dateFilter").on("keyup change",function(){n.column(4).search(this.value).draw()})});

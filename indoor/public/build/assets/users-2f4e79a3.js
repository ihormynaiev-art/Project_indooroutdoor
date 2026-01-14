if($.fn.dataTable.isDataTable("#users-data"))n=$("#users-data").DataTable();else var n=$("#users-data").DataTable({order:[["3","asc"]],ordering:!0,ajax:"users",columnDefs:[{width:"20%",targets:0}],columns:[{data:"name"},{data:"email"},{data:"is_verified",type:"boolean",render:function(e,t,a){return e?'<i class="text-success fa-solid fa-circle-check fa-xl"></i>':'<i class="text-danger fa-solid fa-circle-xmark fa-xl"></i>'}},{data:"roles",render:function(e,t,a){return e.length>0?e[0].name[0].toUpperCase()+e[0].name.slice(1):"User"}},{data:"provider_detail",render:function(e,t,a){return e&&e.plan?`<span class="badge bg-${e.plan.name==="premium"?"primary":"secondary"}">${e.plan.display_name}</span>`:'<span class="text-muted">-</span>'}},{data:"id",orderable:!1,render:function(e,t,a){let r=a.roles.length>0?a.roles[0].name:"";var l=`
                    <div class="action-language">
                        ${r==="provider"?`<a class="table-edit" href="providerDetail/${e}">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>`:""}
                        <a class="table-show" href="users/${e}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a
                            data-id="${e}"
                            data-role="${r}"
                            class="table-role me-1"
                            href="javascript:void(0);"
                            data-bs-toggle="modal"
                            data-bs-target="#change-role"
                        >
                            <i class="fa-regular fa-user"></i>
                            <span>Role</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${e}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return l}}],paging:!0,searching:!0,info:!0,dom:"rtip",language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$("#change-role").on("show.bs.modal",function(e){let t=$(e.relatedTarget),a=t.data("role"),r=$("#role");$(this).find("#id").val(t.data("id")),r.val(a).trigger("change"),a==="super admin"?r.attr("disabled","disabled"):r.attr("disabled",!1)});$("#reply-form").on("submit",function(e){e.preventDefault();var t=$(this),a=t.serialize();let r=$("#id").val();$.ajax({url:`/admin/users/${r}/changeRole`,method:"PATCH",data:a,success:function(s){n.ajax.reload(),$("#change-role").modal("hide")},error:function(s,l,i){$("#change-role").modal("hide")}})});$(document).on("click",".table-resposnive .table-delete",function(){var e="Are you sure want to delete?",t=$(this).data("id"),a=$("#auth-user").val();t==a&&(e=e+" After deleting your own account, you will be logged out"),Swal.fire({title:"Delete user",text:e,showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(r=>{r.isConfirmed&&$.ajax({type:"DELETE",url:"users/"+t,data:{_method:"DELETE",_token:$("#token").val()},success:function(s){t==a&&(window.location.href="/"),s.status==="success"&&n.ajax.reload()}})})});$(document).ready(function(){$("#nameFilter").on("keyup change",function(){n.column(0).search(this.value).draw()}),$("#emailFilter").on("keyup change",function(){n.column(1).search(this.value).draw()})});

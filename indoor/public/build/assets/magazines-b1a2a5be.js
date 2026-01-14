if($.fn.dataTable.isDataTable("#magazines-data"))n=$("#magazines-data").DataTable();else var n=$("#magazines-data").DataTable({ordering:!0,ajax:"magazines",columnDefs:[{width:"20%",targets:0}],columns:[{data:"name",name:"name"},{data:"slug",name:"slug"},{data:"prio",name:"priority"},{data:"is_active",name:"active"},{data:"id",render:function(a,e,t){var s=`
                    <div class="action-language">
                        <a class="table-show" href="/admin/magazineImages/${a}">
                            <i class="fa-regular fa-eye"></i><span>Show</span>
                        </a>
                        <a class="table-edit" href="magazines/${a}/edit">
                            <i class="fa-regular fa-pen-to-square"></i><span>Edit</span>
                        </a>
                        <a class="table-delete" href="javascript:void(0);" data-id="${a}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return s}}],paging:!0,searching:!1,info:!1,dom:'<"custom-datatable"t><"custom-datatable"ilp>',language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var a=$(this).data("id");Swal.fire({title:"Delete Magazine",text:"Are you sure want to delete?",showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(e=>{e.isConfirmed&&$.ajax({type:"DELETE",url:"magazines/"+a+"/",data:{_method:"DELETE",_token:$("#token").val()},success:function(t){t.status==="success"&&n.ajax.reload()}})})});

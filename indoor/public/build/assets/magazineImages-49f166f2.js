var r=window.location.href,s=r.split("/"),o=s[s.length-1];if($.fn.dataTable.isDataTable("#magazine-images-data"))l=$("#magazine-images-data").DataTable();else var l=$("#magazine-images-data").DataTable({ordering:!0,ajax:o,columnDefs:[{width:"20%",targets:0}],columns:[{data:null,render:function(a,i,t){var e=`
                        <div class="table-imgname">
                            <a href="#">
                                <img src="/storage/${a.path}" class="me-2" alt="img">
                            </a>
                        </div>`;return e}},{data:"url",name:"url",render:function(a,i,t){return a||(a=""),`<input class="form-control" id="url" data-id=${t.id} name="url" type="text"  value = ${a}  >`}},{data:"is_active",name:"active",render:function(a,i,t){var e=a?"checked":"",n=`
                        <div class="mx-2 active-switch">
                            <label class="switch">
                                <input name="is_active" id="is_active" value="1" ${e} data-id=${t.id} type="checkbox">
                                <span class="sliders round"></span>
                            </label>
                        </div>`;return n}},{data:"id",render:function(a,i,t){var e=`
                    <div class="action-language">
                        <a class="table-delete" href="javascript:void(0);" data-id="${a}">
                            <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                        </a>
                    </div>`;return e}}],paging:!0,searching:!1,info:!1,dom:'<"custom-datatable"t><"custom-datatable"ilp>',language:{paginate:{first:"",last:"",next:"",previous:""},info:"Showing _START_ - _END_ of _TOTAL_ items",infoFiltered:"",infoEmpty:""}});$(document).on("click",".table-resposnive .table-delete",function(){var a=$(this).data("id");Swal.fire({title:"Delete Image",text:"Are you sure want to delete?",showCancelButton:!0,focusConfirm:!1,confirmButtonText:"delete",cancelButtonText:"close",customClass:{confirmButton:"btn btn-primary mr-3",cancelButton:"btn btn-secondary"},showClass:{popup:"swal2-noanimation",backdrop:"swal2-noanimation"},buttonsStyling:!1}).then(i=>{i.isConfirmed&&$.ajax({type:"DELETE",url:a,data:{_method:"DELETE",_token:$("#token").val()},success:function(t){t.status==="success"&&l.ajax.reload()}})})});$(document).on("change",".table-resposnive input",function(){var a=$(this).data("id"),i=$(this).val(),t=this.id;t==="is_active"&&(i=$(this).prop("checked"));var e={};e._method="PATCH",e._token=$("#token").val(),e[t]=i,$.ajax({type:"PATCH",url:a,data:e,success:function(n){n.status==="success"&&console.log(n.status)}})});

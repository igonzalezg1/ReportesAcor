<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id='changePasswordForm' action="{{ route('cambiarcontrasena') }}">
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="alert alert-danger d-none" id=""></div>
                    <input type="hidden" name="is_active" value="1">
                    <input type="hidden" name="user_id" id="editPasswordValidationErrorsBox">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Contraseña anterior:</label><span class="required confirm-pwd"></span><span
                                class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="passwordold" type="password"
                                    name="passwordold" required>
                                <div class="input-group-append input-group__icon">
                                    <span class="input-group-text changeType">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nueva contraseña:</label><span class="required confirm-pwd"></span><span
                                class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="password" type="password"
                                    name="password" required>
                                <div class="input-group-append input-group__icon">
                                    <span class="input-group-text changeType">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Confirma la contraseña:</label><span class="required confirm-pwd"></span><span
                                class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="confirm-password" type="password"
                                    name="confirm-password" required>
                                <div class="input-group-append input-group__icon">
                                    <span class="input-group-text changeType">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="save"
                            data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">
                            Guardar contraseña
                        </button>
                        <button type="button" class="btn btn-danger ml-1" data-dismiss="modal">Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="changeImageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar foto de perfil</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id='changePasswordForm' action="{{ route('cambiarfotop') }}"
                enctype="multipart/form-data">
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="alert alert-danger d-none" id=""></div>
                    <input type="hidden" name="is_active" value="1">
                    <input type="hidden" name="user_id" id="editPasswordValidationErrorsBox">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label>Eleguir foto de perfil:</label><span class="required confirm-pwd"></span><span
                                class="required">*</span>
                            <div class="input-group">
                                <input class="form-control input-group__addon" id="profile_image" type="file"
                                    name="profile_image" accept="image/*" required>
                                <div class="input-group-append input-group__icon">
                                    <span class="input-group-text changeType">
                                        <i class="icon-ban icons"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="btnPrPasswordEditSave"
                            data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-danger ml-1" data-dismiss="modal">Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

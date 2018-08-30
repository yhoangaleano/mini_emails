<div class="row">
  <div class="col-md-6 offset-md-3">
    
  <form class="form-horizontal" method="POST" action="<?php echo URL; ?>pacientes/guardar">
<fieldset>

<!-- Form Name -->
<legend>Crear un paciente</legend>

<!-- Text input-->
<div class="form-group">
  <label for="txtDocumento">Documento paciente</label>  
  <input id="txtDocumento" name="txtDocumento" type="text" placeholder="Ejm: 121457162718" class="form-control">
</div>

<!-- Text input-->
<div class="form-group">
  <label for="txtNombre">Nombre del paciente</label>  
  <input id="txtNombre" name="txtNombre" type="text" placeholder="Ejm: Yhoan Andres" class="form-control">
</div>

<!-- Text input-->
<div class="form-group">
  <label for="txtApellido">Apellido del paciente</label>  
  <input id="txtApellido" name="txtApellido" type="text" placeholder="Ejm: Galeano Urrea" class="form-control">
</div>

<!-- Text input-->
<div class="form-group">
  <label for="txtEPSPaciente">EPS del paciente</label>  
  <input id="txtEPSPaciente" name="txtEPSPaciente" type="text" placeholder="Ejm: Salud Total" class="form-control">
</div>

<!-- Button -->
<div class="form-group">
  <div class="row">

<div class="col-md-6">
    <button id="btnGuardar" name="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
  </div>

  <div class="col-md-6">
    <button id="btnCancelar" name="btnCancelar" class="btn btn-default btn-block" type="reset">Cancelar</button>
  </div>

  </div>
</div>

</fieldset>
</form>


  </div>
</div>
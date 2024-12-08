<?php include('../templates/cabecera.php'); ?>
<?php include('../secciones/alumnos.php'); ?>
<br/>
<div class="row">
    <div class="col-5">
        <form action="" method="post">
            <div class="card">
                <div class="card-header">Alumnos</div>
                <div class="card-body">
                    <div class="mb-3 d-none">
                        <label for="" class="form-label">ID</label>
                        <input
                            type="text"
                            class="form-control"
                            name="id"
                            id="id"
                            aria-describedby="helpId"
                            placeholder="ID"
                            value="<?php echo $id; ?>"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nombre"
                            id="nombre"
                            aria-describedby="helpId"
                            placeholder="Escribe tu nombre"
                            value="<?php echo $nombre; ?>"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Apellidos</label>
                        <input
                            type="text"
                            class="form-control"
                            name="apellidos"
                            id="apellidos"
                            aria-describedby="helpId"
                            placeholder="Escribe tus apellidos"
                            value="<?php echo $apellidos; ?>"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Curso del alumno</label>
                        <select multiple class="form-control" name="cursos[]" id="listaCursos">
                            <?php foreach($cursos as $curso) {?>
                                <option 
                                <?php 
                                    if(!empty($arregloCursos)):
                                        if(in_array($curso['id'],$arregloCursos)):
                                            echo 'selected';
                                        endif;
                                    endif;
                                ?>
                                
                                value="<?php echo $curso['id']; ?>">
                                <?php echo $curso['id']; ?> -  <?php echo $curso['nombre_curso']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button
                            type="submit"
                            class="btn btn-success"
                            name="accion"
                            value="agregar"
                        >
                            Agregar
                        </button>
                        <button
                            type="submit"
                            class="btn btn-warning"
                            name="accion"
                            value="editar"
                        >
                            Editar
                        </button>
                        <button
                            type="submit"
                            class="btn btn-danger"
                            name="accion"
                            value="borrar"
                        >
                            Borrar
                        </button>
                    </div>
                    
                    
                    
                </div>
                <div class="card-footer text-muted">Footer</div>
            </div>
            
        </form>
    </div>
    <div class="col-7">
        <div
            class="table-responsive"
        >
            <table
                class="table table-primary"
            >
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($alumnos as $alumno):?>
                    <tr>
                        <td><?php echo $alumno['id'];?></td>
                        <td>
                            <?php echo $alumno['nombre'];?><?php echo $alumno['apellidos'];?>
                            <br/>
                            <?php foreach($alumno["cursos"] as $curso){?>
                                   - <a href="certificado.php?idcurso=<?php echo $curso['id'];?>&idalumno=<?php echo $alumno['id'];?>">
                                   <i class="bi bi-filetype-pdf text-danger"></i><?php echo $curso['nombre_curso'];?>
                                    </a><br/>
                                    <?php }?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $alumno['id'];?>">
                                <input type="submit" value="Seleccionar" name="accion" class="btn btn-info">
                            </form>

                        </td>
                    </tr>
                    <?php endforeach;?>
                    <tr class="">
                        <td scope="row">Item</td>
                        <td>Item</td>
                        <td>Item</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>




<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.1/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#listaCursos');
</script>
<?php include('../templates/pie.php'); ?>
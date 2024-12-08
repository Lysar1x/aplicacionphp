<?php 
    include_once '../configuraciones/bd.php';
    $conexionBD=BD::crearInstancia();
    
    //Datos del alumno
    $id=isset($_POST['id'])?$_POST['id']:'';
    $nombre=isset($_POST['nombre'])?$_POST['nombre']:'';
    $apellidos=isset($_POST['apellidos'])?$_POST['apellidos']:'';
    //Datos del curso
    $cursos=isset($_POST['cursos'])?$_POST['cursos']:'';
    //Acción
    $accion=isset($_POST['accion'])?$_POST['accion']:'';

    if($accion!=""){
        switch($accion){
            case 'agregar':
                $sql="INSERT INTO alumnos (id, nombre, apellidos) VALUES (NULL,:nombre,:apellidos)";
                $consulta=$conexionBD->prepare($sql);
                $consulta->bindParam(':nombre',$nombre);
                $consulta->bindParam(':apellidos',$apellidos);
                $consulta->execute();

                $idAlumno=$conexionBD->lastInsertId();
                
                foreach($cursos as $curso){
                    $sql="INSERT INTO alumnos_cursos (id, idalumno, idcurso) VALUES (NULL,:idalumno,:idcurso)";
                    $consulta=$conexionBD->prepare($sql);
                    $consulta->bindParam(':idalumno',$idAlumno);
                    $consulta->bindParam(':idcurso',$curso);
                    $consulta->execute();
                        }
                break;
                case 'Seleccionar':
                    

                    $sql="SELECT * FROM alumnos WHERE id=:id";
                    $consulta=$conexionBD->prepare($sql);
                    $consulta->bindParam(':id',$id);
                    $consulta->execute();
                    $alumno=$consulta->fetch(PDO::FETCH_ASSOC);

                    $nombre=$alumno['nombre'];
                    $apellidos=$alumno['apellidos'];


                    $sql="SELECT cursos.id FROM alumnos_cursos INNER JOIN cursos ON cursos.id=alumnos_cursos.idcurso WHERE alumnos_cursos.idalumno=:idalumno";
                    $consulta=$conexionBD->prepare($sql);
                    $consulta->bindParam(':idalumno',$id);
                    $consulta->execute();
                    $cursosAlumno=$consulta->fetchALL(PDO::FETCH_ASSOC);

                    print_r($cursosAlumno);

                    foreach($cursosAlumno as $curso){
                        $arregloCursos[]=$curso['id'];

                    }

                    break;
                    case 'borrar':
                        if (isset($id) && !empty($id)) {
                            $sql = "DELETE FROM alumnos WHERE id = :id";
                            $consulta = $conexionBD->prepare($sql);
                            $consulta->bindParam(':id', $id, PDO::PARAM_INT); // Especificar el tipo de dato
                            $consulta->execute();
                        } else {
                            // Manejo del error
                            echo "ID no válido.";
                        }
                       case "editar":
                        $sql="UPDATE alumnos SET nombre=:nombre, apellidos=:apellidos WHERE id=:id";
                        $consulta = $conexionBD->prepare($sql);
                        $consulta->bindParam(':nombre', $nombre);
                        $consulta->bindParam(':apellidos', $apellidos);
                        $consulta->bindParam(':id', $id);
                        $consulta->execute();

                        if(isset($cursos)){
                            $sql="DELETE FROM alumnos_cursos WHERE idalumno=:idalumno";
                            $consulta=$conexionBD->prepare($sql);
                            $consulta->bindParam(':idalumno',$id);
                            $consulta->execute();

                            foreach($cursos as $curso){
                                $sql="INSERT INTO alumnos_cursos (id, idalumno, idcurso)
                                VALUES (NULL,:idalumno,:idcurso)";
                                $consulta=$conexionBD->prepare($sql);
                                $consulta->bindParam(':idalumno', $id);
                                $consulta->bindParam(':idcurso', $curso);
                                $consulta->execute();
                            }
                            $arregloCursos=$cursos;
                        }


        }               
    }
    $sql="SELECT * FROM alumnos";
    $listaAlumnos=$conexionBD->query($sql);
    $alumnos=$listaAlumnos->fetchAll();

    foreach($alumnos as $clave =>$alumno){
        $sql="SELECT * FROM cursos WHERE id IN (SELECT idcurso FROM alumnos_cursos WHERE idalumno=:idalumno)";
        $consulta=$conexionBD->prepare($sql);
        $consulta->bindParam(':idalumno',$alumno['id']);
        $consulta->execute();
        $cursosAlumno=$consulta->fetchALL();
        $alumnos[$clave]['cursos']=$cursosAlumno;
    }

    $sql="SELECT * FROM cursos";
    $listaCursos=$conexionBD->query($sql);
    $cursos=$listaCursos->fetchALL();

    
?>
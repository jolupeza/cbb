export const dict = {
  custom: {
    parent_terms: {
      required: 'Debe aceptar las condiciones del proceso de admisión'
    },
    parent_name: {
      required: 'Debe ingresar su nombre'
    },
    parent_dni: {
      required: 'Debe ingresar el número de su D.N.I.',
      min: 'Debe contener 8 dígitos',
      max: 'Debe contener 8 dígitos',
      regex: 'Ingresar sólo dígitos',
    },
    parent_phone: {
      required: 'Debe ingresar su número de teléfono o celular',
      min: 'Verifique que es correcto',
      max: 'Verifique que es correcto',
      regex: 'Ingresar sólo dígitos',
    },
    parent_email: {
      required: 'Debe ingresar su email',
      email: 'Ingresar email válido'
    },
    parent_sede: {
      required: 'Debe seleccionar la Sede de su interés'
    },
    schedule: {
      required: 'Debe seleccionar el horario o indicar otro'
    },
    schedule_custom: {
      required: 'Debe seleccionar el horario de su preferencia'
    },
    son_name: {
      required: 'Debe ingresar el nombre de su hij(o/a)'
    },
    son_level: {
      required: 'Debe seleccionar el Grado'
    }
  }
}

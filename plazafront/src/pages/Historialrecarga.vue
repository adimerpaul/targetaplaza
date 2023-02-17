<template>
<q-page class="q-pa-xs">
  <div class="col-12">
    <q-table
      title="HISTORIAL DE RECARGAS"
      :rows="filas"
      :columns="columns"
      row-key="name"
      :filter="filter"
    >
    <template v-slot:top-right>
                          <q-input dense outlined debounce="300" v-model="filter" placeholder="Buscar" >
                <template v-slot:append>
                  <q-icon name="search" />
                </template>
              </q-input>
             <q-btn color="deep-purple-6" label="Exportar Excel"  @click="exportTable"/>

            </template>
    </q-table>
  <!--<div class=" responsive">
    <table id="example" class="display" style="width:100%">
      <thead>
      <tr>
        <th>NRO</th>
        <th>FECHA</th>
        <th>HORA</th>
        <th>MONTO</th>
        <th>CLIENTE</th>
        <th>USUARIO</th>

      </tr>
      </thead>
      <tbody>
      <tr v-for="fila in filas" :key="fila">
        <td>{{fila.num}}</td>
        <td>{{fila.fecha}}</td>
        <td>{{fila.hora}}</td>
        <td>{{fila.monto}}</td>
        <td>{{fila.nombre}} </td>
        <td>{{fila.usuario}}</td>
      </tr>
      </tbody>
    </table>-->
  </div>
</q-page>
</template>

<script>
import xlsx from "json-as-xlsx"

export default {
  data(){
    return{
      filas:[],
      filter:'',
      columns:[
        {name:'num',field:'num',label:'No',sortable:true},
        {name:'fecha',field:'fecha',label:'FECHA',sortable:true},
        {name:'hora',field:'hora',label:'HORA',sortable:true},
        {name:'monto',field:'monto',label:'MONTO',sortable:true},
        {name:'cliente',field:'nombre',label:'CLIENTE',sortable:true},
        {name:'usuario',field:'usuario',label:'USUARIO',sortable:true}
      ]
    }
  },
  mounted() {
    this.misdatos()
    /*$('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );*/
  },
  methods:{
    exportTable () {
let datacaja = [
  {
    sheet: "Recargas",
    columns: [
      { label: "No", value: "num" }, // Top level data
      { label: "Fecha", value: "monto" }, // Top level data
      { label: "Hora", value: "hora" }, // Top level data
      { label: "Monto", value: "monto" }, // Top level data
      { label: "Cliente", value: "nombre" }, // Top level data
      { label: "Usuario", value: "usuario" }, // Top level data
    ],
    content: this.filas
  },

]

let settings = {
  fileName: "HistRecarga", // Name of the resulting spreadsheet
  extraLength: 5, // A bigger number means that columns will be wider
  writeOptions: {}, // Style options from https://github.com/SheetJS/sheetjs#writing-options
}

xlsx(datacaja, settings) // Will download the excel file
      },

    misdatos(){
      this.$q.loading.show()
      this.filas=[]
      this.$axios.get(process.env.API+'/listRecarga').then( res=>{
        // console.log(res.data);
        let num=0
        res.data.forEach(r => {
          num++
            r.num=num
            r.usuario=r.name
            r.nombre=r.nombre +' ' + r.apellido
            this.filas.push(r)
        });
        this.$q.loading.hide();

       /* $('#example').DataTable().destroy();
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );
          this.$q.loading.hide();
        })*/
      }).catch(err=>{
          this.$q.loading.hide();
        this.$q.notify({
          message:err.message,
          color:'red',
          icon:'error'
        })
      })
    }
  }
}
</script>

<style scoped>

</style>

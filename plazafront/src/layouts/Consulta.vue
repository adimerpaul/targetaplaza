<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />
        <q-toolbar-title>
          {{$store.state.login.user.name}}
        </q-toolbar-title>

        <div>
        <q-btn v-if="$store.getters['login/isLoggedIn']" label="Salir" @click="logout"  color="negative" icon="logout" size="xs" />
        </div>
      </q-toolbar>
      <div class="q-px-lg q-pt-xs q-mb-md" >
        <div class="text-h5 text-bold">
          MULTICINES PLAZA
<!--          <template v-if="!$store.getters['login/isLoggedIn']">-->
<!--          Correspondencia-->
<!--          </template>-->
<!--          <template v-else>-->
<!--            Unidad: {{$store.state.login.user.unit.nombre}}-->
<!--          </template>-->
        </div>
        <div class="text-subtitle1">{{ now }}</div>
      </div>
      <q-img src="img/fondo.jpg" class="header-image absolute-top" />
    </q-header>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      :width="250"
      :breakpoint="600"
    >
      <q-scroll-area style="height: calc(100% - 130px); margin-top: 130px; border-right: 1px solid #ddd">
        <q-list padding>
          <q-item
            clickable
            exact
            to="/consulta"
          >
            <q-item-section
              avatar
            >
              <q-icon name="shop" />
            </q-item-section>

            <q-item-section>
              <q-item-label>Consulta de saldo</q-item-label>
              <q-item-label caption>
                Consulta de saldo
              </q-item-label>
            </q-item-section>
          </q-item>


        </q-list>
      </q-scroll-area>

      <q-img class="absolute-top" src="img/fondo.jpg" style="height: 130px">
        <div class="absolute-bottom bg-transparent ">
          <!--          <q-avatar size="56px" class="q-mb-sm">-->
          <!--            <img src="https://cdn.quasar.dev/img/boy-avatar.png">-->
          <!--          </q-avatar>-->
          <div class="text-weight-bold">Recarga de targetas </div>
          <div>Menu</div>
        </div>
      </q-img>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import {date} from 'quasar'
export default {
  data(){
    return{
      leftDrawerOpen : false,
      now :date.formatDate(Date.now(), 'dddd D  MMMM', {
        days: ['Domingo', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado' /* and all the rest of days - remember starting with Sunday */],
        daysShort: ['Dum', 'Lun', /* and all the rest of days - remember starting with Sunday */],
        months: ['Enero', 'Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre' /* and all the rest of months */],
        monthsShort: ['Ian', 'Feb', /* and all the rest of months */]
      }),
      unidad:'aa',
    }
  },
  created() {
    // console.log(this.$store.getters['login/user'])
    // this.unidad=this.$store.getters['login/user'];
  },
  methods:{
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout () {
      this.$q.loading.show()
      this.$store.dispatch('login/logout')
        .then(() => {
          this.$q.loading.hide()
          this.$router.push('/')
        })
    },
  }
}
</script>
<style lang="scss">
.header-image{
  height: 100%;
  z-index: -1;
  opacity: 0.2;
  filter: grayscale(100%);
}
</style>

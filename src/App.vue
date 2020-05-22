<template>
  <v-app id="keep">
    <v-app-bar
      app
      clipped-left
      color="black"
    >
      <v-app-bar-nav-icon @click="drawer = !drawer" class="hidden-md-and-up"></v-app-bar-nav-icon>
      <span class="appname ml-3 mr-5 hidden-sm-and-down text-white">{{ $t('appname') }}</span>
      <div class="flex-grow-1"></div>
      <v-img contain v-on:click.native="jumpToLang('/en')" :src="require('@/assets/img/en_flag.png')" class="mr-1" max-height="30" max-width="80"></v-img>
      <v-img contain v-on:click.native="jumpToLang('/hu')" :src="require('@/assets/img/hu_flag.png')" class="mr-1" max-height="30" max-width="80"></v-img>
    </v-app-bar>


    <v-navigation-drawer
      v-model="drawer"
      app
      clipped
      color="black"
    >
      <NavigationDrawer />
    </v-navigation-drawer>

    <v-content>
            <v-card
              class="mx-auto"
              width="100%"
            >
              <v-card-text class="mainContent">
                <router-view/>
              </v-card-text>
            </v-card>

    </v-content>
  </v-app>
</template>


<script>
import NavigationDrawer from '@/components/NavigationDrawer'
import './styles/local.scss'

export default {
  name: 'app',
  props: {
    source: String
  },
  components: {
    NavigationDrawer
    // WavePlaylist
  },
  methods: {
    jumpToLang (langcode) {
      // console.log(langcode)
      window.location.href = langcode
    }
  },
  data: () => ({
    drawer: null,
    search: ''
  })
}
</script>


<style css>
@import url('https://fonts.googleapis.com/css?family=Rubik:300,400,500,700&amp;subsetlatin-exthttps://fonts.googleapis.com/css?family=Rubik:300,400,500,700&amp;subset=cyrillic,cyrillic-ext,latin-ext');
@import url('https://cdn.jsdelivr.net/npm/@mdi/font@3.x/css/materialdesignicons.min.css');

#keep .v-navigation-drawer__border {
  display: none
}

.appname {
  font-size: 32px;
  text-shadow: 1px 1px 4px #c0c0c0;
}

/*
.mainContent, .v-dialog {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}
*/
</style>

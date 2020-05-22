<template>
  <div class="align-center">
  <v-list
    dense
  >
    <template v-for="(item, i) in items">
      <v-list-item
        :key="i"
        @click=""
        :to="$i18nRoute({ name: item.url })"
      >
      <!--
        <v-list-item-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-action>
        -->
        <v-list-item-content>
          <v-list-item-title class="text-white">
            {{ $t(item.text) }}
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </template>
  </v-list>
  </div>
</template>

<script>
export default {
  name: 'NavigationDrawer',
  data () {
    return {
      items: [
        { text: 'pages.notationtest', url: 'notationtest' },
        { text: 'pages.notationtest2', url: 'notationtest2' }
      ]
    }
  }
}
</script>


<style scoped>
img.logo {
  max-width: 60%;
  margin-left: 20%;
}
.v-list--dense .v-list-item .v-list-item__title {
  font-size: 20px;
}
</style>

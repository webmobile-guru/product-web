<template>
  <div>

    <reactive-base
      :app="app"
      url="https://elastic.h3online.com"
      :credentials="credentials"
    >
      <v-container>
        <v-row>
          <v-col :sm="8" :xl="9">

            <!--
            <SelectedFilters />
            -->

            <reactive-list
              componentId="SearchResult"
              dataField="item_id.keyword"
              className="result-list-container"
              sortBy="desc"
              :pagination="true"
              :from="0"
              :size="20"
              :react="{ and: ['T1', 'T2', 'T4'] }"
              :innerClass="{ list: 'woas-container' }"
            >
              <div
                style="width: 100%;"
                slot="renderResultStats"
                slot-scope="{ numberOfResults, time, displayedResults }"
              >
                {{ numberOfResults }} {{ $t("items") }}

              </div>

              <template slot="renderItem" slot-scope="{ item }">
                <template>
                  <div :class="cardWidth">
                    <woa-card
                      key="item._id"
                      :item="item"
                      :lang="lang"
                    >
                    </woa-card>
                  </div>
                </template>
              </template>
            </reactive-list>
          </v-col>
          <v-col :sm="4" :xl="3" class="filters">
            <reactive-component
              componentId="T1"
              :defaultQuery="taxonomy1DefaultQuery"
              class="filter mb-10"
              :URLParams="true"
              filterLabel="Taxonomy 1"
              :react="{ and: ['T2', 'T4'] }"
            >
              <div slot-scope="{ aggregations, setQuery, loading, value }">
                <tree-view
                  :setQuery="setQuery"
                  :aggregations="aggregations"
                  :levels="2"
                  field="taxonomy_1"
                  :placeholder="$t('all')"
                  componentID="T1"
                  :selectedValue="value"
                  :title="$t('genres')"
                />
              </div>
            </reactive-component>

            <reactive-component
              componentId="T2"
              :defaultQuery="taxonomy2DefaultQuery"
              class="filter mb-10"
              :URLParams="true"
              filterLabel="Taxonomy 2"
              :react="{ and: ['T1', 'T4'] }"
            >
              <div slot-scope="{ aggregations, setQuery, loading, value }">
                <tree-view
                  :setQuery="setQuery"
                  :aggregations="aggregations"
                  :levels="2"
                  field="taxonomy_2"
                  :placeholder="$t('all')"
                  componentID="T2"
                  :selectedValue="value"
                  :title="$t('contofperf')"
                />
              </div>
            </reactive-component>

            <reactive-component
              componentId="T4"
              :defaultQuery="taxonomy4DefaultQuery"
              class="filter mb-10"
              :URLParams="true"
              filterLabel="Taxonomy 4"
              :react="{ and: ['T1', 'T2'] }"
            >
              <div slot-scope="{ aggregations, setQuery, loading, value }">
                <tree-view
                  :setQuery="setQuery"
                  :aggregations="aggregations"
                  :levels="2"
                  field="taxonomy_4"
                  :placeholder="$t('all')"
                  componentID="T4"
                  :selectedValue="value"
                  :title="$t('themesandmotifs')"
                />
              </div>
            </reactive-component>

          </v-col>
        </v-row>
      </v-container>
    </reactive-base>
  </div>
</template>

<script>
import WoaCard from '@/components/WoaCard'
import WoaVideoDialog from '@/components/WoaVideoDialog'
import TreeView from './TreeView'

export default {
  name: 'WoaListES',
  methods: {
    taxonomy1DefaultQuery () {
      return {
        aggs: {
          'l1': {
            terms: {
              field: 'taxonomy_1.level_1.name.keyword',
              size: 100,
              order: {
                _count: 'desc'
              }
            },
            aggs: {
              'l2': {
                terms: {
                  field: 'taxonomy_1.level_1.level_2.name.keyword',
                  size: 100,
                  order: {
                    _count: 'desc'
                  }
                },
                aggs: {
                  'l3': {
                    terms: {
                      field: 'taxonomy_1.level_1.level_2.level_3.name.keyword',
                      size: 100,
                      order: {
                        _count: 'desc'
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    },
    taxonomy2DefaultQuery () {
      return {
        aggs: {
          'l1': {
            terms: {
              field: 'taxonomy_2.level_1.name.keyword',
              size: 100,
              order: {
                _count: 'desc'
              }
            },
            aggs: {
              'l2': {
                terms: {
                  field: 'taxonomy_2.level_1.level_2.name.keyword',
                  size: 100,
                  order: {
                    _count: 'desc'
                  }
                }/*,
                aggs: {
                  'l3': {
                    terms: {
                      field: 'taxonomy_2.level_1.level_2.level_3.name.keyword',
                      size: 100,
                      order: {
                        _count: 'desc'
                      }
                    }
                  }
                }
                */
              }
            }
          }
        }
      }
    },
    taxonomy4DefaultQuery () {
      return {
        aggs: {
          'l1': {
            terms: {
              field: 'taxonomy_4.level_1.name.keyword',
              size: 100,
              order: {
                _count: 'desc'
              }
            },
            aggs: {
              'l2': {
                terms: {
                  field: 'taxonomy_4.level_1.level_2.name.keyword',
                  size: 100,
                  order: {
                    _count: 'desc'
                  }
                }/*,
                aggs: {
                  'l3': {
                    terms: {
                      field: 'taxonomy_2.level_1.level_2.level_3.name.keyword',
                      size: 100,
                      order: {
                        _count: 'desc'
                      }
                    }
                  }
                }
                */
              }
            }
          }
        }
      }
    }
  },
  components: {
    TreeView,
    WoaVideoDialog,
    WoaCard
  },
  computed: {
    cardWidth () {
      if (this.list_view) return ''
      switch (this.$vuetify.breakpoint.name) {
        case 'xs':
          return 'item-100'
        case 'sm':
          return 'item-100'
        case 'md':
          return 'item-50'
        case 'lg':
          return 'item-50'
        case 'xl':
          return 'item-33'
      }
    }
  },
  props: ['app', 'credentials', 'lang', 'type']
}
</script>

<style>
.woas-container .item-100 {
  width: 98%;
  display: inline-block;
  margin: 1%;
}
.woas-container .item-50 {
  width: 48%;
  display: inline-block;
  margin: 1%;
}
.woas-container .item-33 {
  width: 31%;
  display: inline-block;
  margin: 1%;
}
.woas-container ul.css-bbs1vb li {
  height: auto;
}
.tableHeader {
  font-weight: 500;
  background-color: #ddd;
  margin-top: 20px;
}
.filters {
  margin-top: 25px;
}
</style>

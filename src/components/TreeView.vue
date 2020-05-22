<!-- Vue SFC -->
<template>
  <div>
    <h2 class="title">{{ title }}</h2>
    <treeselect
      :multiple="true"
      :value="selectedValue"
      :options="treeData"
      @input="onInputChange"
      @select="onSelect"
      @deselect="onDeSelect"
      :placeholder="placeholder"

    >
      
      <label
      slot="option-label"
      :title=node.label
      slot-scope="{ node, shouldShowCount, count, labelClassName, countClassName }" :class="labelClassName">
        {{ node.label }}<span v-if="shouldShowCount" :class="countClassName">({{ count }})</span>
      </label>      
    
    </treeselect>
  </div>
</template>

<script>
// import the component
import Treeselect from '@riophae/vue-treeselect'
// import the styles
import '@riophae/vue-treeselect/dist/vue-treeselect.css'

const queryBuilder = (field, values) => {
  const getTermsQuery = (keyword, value) => {
    let actualKey = ''
    const levels = parseInt(keyword.split('l')[1], 10)
    for (let i = 1; i <= levels; i++) {
      actualKey += `.level_${i}`
    }
    return {
      terms: {
        [`${field}${actualKey}.name.keyword`]: value
      }
    }
  }
  const queryHash = {};
  (values || []).forEach(value => {
    const splittedTerms = value.split('__')
    for (let i = 0; i < splittedTerms.length; i += 2) {
      const val = splittedTerms[i]
      const group = splittedTerms[i + 1]
      if (!Array.isArray(queryHash[group])) queryHash[group] = []
      const hasVal = queryHash[group].find(item => item === val)
      if (!hasVal) {
        queryHash[group].push(val)
      }
    }
  })
  return ({
    query: {
      bool: {
        must: Object.keys(queryHash).map(key =>
          getTermsQuery(key, queryHash[key])
        )
      }
    },
    size: 15,
    value: values
  })
}

export default {
  // register the component
  components: { Treeselect },
  props: {
    aggregations: Object,
    setQuery: Function,
    levels: Number,
    field: String,
    title: String,
    placeholder: String,
    componentID: String,
    selectedValue: Array
  },
  created: function () {
    const query = queryBuilder(this.field, this.selectedValue)
    this.setQuery(query)
  },
  methods: {
    onInputChange (values, instanceId) {
      const query = queryBuilder(this.field, values)
      this.setQuery(query)
    },
    onSelect (node, instanceId) {
    },
    onDeSelect (node, instanceId) {
    }
  },
  computed: {
    treeData () {
      const selectedVals = {}
      if (this.selectedValue) {
        this.selectedValue.forEach(i => {
          selectedVals[i] = false
        })
      }
      const levelBuilder = (level) => `l${level}`
      const getTreeView = (levels, aggregations, nextLevel = 1, parentPath = '') => {
        const { buckets } = aggregations[`l${nextLevel}`]
        if (nextLevel < levels) {
          return buckets.map(bucket => {
            const newLevel = nextLevel + 1
            let id = `${bucket.key}__${levelBuilder(
              nextLevel
            )}`
            if (nextLevel > 1) {
              id += parentPath
            }

            if (selectedVals[id] === false) {
              selectedVals[id] = true
            }

            const label = `${bucket.key}    (${bucket.doc_count})`
            const childObj = {}

            if (bucket[`l${newLevel}`] && !bucket[`l${newLevel}`].buckets.length) {
              childObj.path = levelBuilder(
                nextLevel
              )
            } else {
              const newParentPath = `__${bucket.key}__${levelBuilder(nextLevel)}`
              const children = getTreeView(levels, bucket, newLevel, newParentPath)
              childObj.children = children
            }
            return {
              id,
              label,
              ...childObj
            }
          })
        } else if (levels === nextLevel) {
          return buckets.map(bucket => {
            let id = `${bucket.key}__${levelBuilder(
              nextLevel
            )}`
            if (nextLevel > 1) {
              id += parentPath
            }
            if (selectedVals[id] === false) {
              selectedVals[id] = true
            }

            const label = `${bucket.key}    (${bucket.doc_count})`
            const path = levelBuilder(
              nextLevel
            )
            return {
              id,
              label,
              path
            }
          })
        }
        return []
      }
      if (this.aggregations) {
        const treeData = getTreeView(
          parseInt(this.levels, 10),
          this.aggregations
        )

        Object.keys(selectedVals).forEach(item => {
          if (!selectedVals[item]) {
            const splitedKey = item.split('__')
            treeData.push({
              id: item,
              label: `${splitedKey[0]}   (0)`,
              path: splitedKey[1]
            })
          }
        })
        return treeData
      }
      return []
    }
  }
}
</script>

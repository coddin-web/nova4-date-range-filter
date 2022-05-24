<template>
  <div class="pt-2 pb-3">
    <h3 class="px-3 text-xs uppercase font-bold tracking-wide"><span>{{ filter.name }}</span></h3>

    <div class="p-2">
      <input
        class="w-full form-control form-input form-input-bordered"
        :disabled="disabled"
        :class="{'!cursor-not-allowed': disabled}"
        :value="value"
        ref="datePicker"
        type="text"
        :placeholder="placeholder"
      />
    </div>
  </div>
</template>
<script>
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import '../../airbnb-modified.css';

export default {
  props: {
    resourceName: {
      type: String,
      required: true,
    },
    filterKey: {
      type: String,
      required: true,
    },

  },

  data: () => ({ flatpickr: null }),

  computed: {
    placeholder() {
      return this.filter.options.find(item => item.label == 'placeholder')?.value || this.__('Pick a date range')
    },
    startDate() {
      return flatpickr.formatDate(flatpickr.parseDate(this.filter.currentValue[0], this.dateFormat), this.dateFormat)
    },
    endDate() {
      return flatpickr.formatDate(flatpickr.parseDate(this.filter.currentValue[1], this.dateFormat), this.dateFormat)
    },
    value() {
      if (typeof this.filter.currentValue === 'object' && this.filter.currentValue.length >= 2){
        return `${this.startDate} ${this.separator} ${this.endDate}`
      }
      return this.filter.currentValue || null
    },
    filter() {
      return this.$store.getters[`${this.resourceName}/getFilter`](this.filterKey)
    },
    options() {
      return this.$store.getters[`${this.resourceName}/getOptionsForFilter`](
        this.filterKey
      )
    },
    disabled() {
      return this.filter.options.find(item => item.label == 'disabled')?.value
    },
    separator() {
      return this.filter.options.find(item => item.label == 'separator')?.value || '-'
    },
    modeType() {
      return (this.filter.options.find(item => item.label == 'mode')?.value === 'range') ? 'range' : 'single'
    },
    dateFormat() {
      return this.filter.options.find(item => item.label == 'dateFormat')?.value || (this.enableTime ? 'Y-m-d H:i' : 'Y-m-d')
    },
    twelveHourTime() {
       return this.filter.options.find(item => item.label == 'twelveHourTime')?.value
    },
    enableTime() {
      return this.filter.options.find(item => item.label == 'enableTime')?.value
    },
    enableSeconds() {
      return this.filter.options.find(item => item.label == 'enableSeconds')?.value
    },
    firstDayOfWeek() {
      return this.filter.options.find(item => item.label == 'firstDayOfWeek')?.value || 0
    }
  },

  mounted() {
    const self = this;
    this.$nextTick(() => {
      this.flatpickr = flatpickr(this.$refs.datePicker, {
        enableTime: this.enableTime,
        enableSeconds: this.enableSeconds,
        onClose: this.handleChange,
        dateFormat: this.dateFormat,
        allowInput: true,
        // static: true,
        mode: this.modeType,
        time_24hr: !this.twelveHourTime,
        onReady() {
          self.$refs.datePicker.parentNode.classList.add('date-filter')
        },
        locale: {
          rangeSeparator: ` ${this.separator} `,
          firstDayOfWeek: this.firstDayOfWeek
        }
      })
    })
  },

  methods: {
    handleChange(value) {
        setTimeout(() => {
            value = value.map(value => {
                return flatpickr.formatDate(value, this.dateFormat)
            })

            if (Object.keys(value).length !== 0) {
                this.$store.commit(`${this.resourceName}/updateFilterState`, {
                    filterClass: this.filterKey,
                    value,
                });
                this.$emit('change')
            }
        }, 100)
    },
  }
}
</script>
<style scoped>
.\!cursor-not-allowed {
  cursor: not-allowed !important;
}
</style>

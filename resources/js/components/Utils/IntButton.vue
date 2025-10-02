<template>
  <a
    v-if="href"
    :class="[
      button_class,
      roundedClass(),
      `hover:text-${hoverTextSize}`,
      'transform transition-all duration-200',
    ]"
    :href="href"
    :target="target"
    @click="emit('click')"
    @mouseover="emit('mouseover')"
    @mouseout="emit('mouseout')"
    class="text-center max-w-full inline-block text-button"
  >
    <slot>
      <i
        :class="icon_class"
        v-if="icon && icon_position === 'left'"
      ></i>
      {{ action }}
      <i
        :class="icon_class"
        v-if="icon && icon_position === 'right'"
      ></i>
    </slot>
  </a>
  <button
    v-else
    :class="[
      button_class,
      roundedClass(),
      `hover:text-${hoverTextSize}`,
      'transform transition-all duration-200',
    ]"
    @click="emit('click')"
    @mouseover="emit('mouseover')"
    @mouseout="emit('mouseout')"
    class="text-center max-w-full text-button"
  >
    <slot>
      <i
        :class="icon_class"
        v-if="icon && icon_position === 'left'"
      ></i>
      {{ action }}
      <i
        :class="icon_class"
        v-if="icon && icon_position === 'right'"
      ></i>
    </slot>
  </button>
</template>

<script setup>
  import { computed } from 'vue'

  const props = defineProps({
    target: {
      type: String,
      default: '_self',
    },
    action: String,
    active: {
      type: Boolean,
      default: true,
    },
    enabled: {
      type: Boolean,
      default: true,
    },
    color: {
      type: String,
      default: 'secondary',
    },
    type: {
      type: String,
      default: 'primary',
    },
    icon: {
      type: String,
      default: '',
    },
    icon_position: {
      type: String,
      default: 'right',
    },
    href: {
      type: String,
      default: null,
    },
    padding: {
      type: String,
      default: ' px-3 py-3 ',
    },
    rounded: {
      type: String,
      default: '',
    },
    hoverTextSize: {
      type: String,
      default: 'base',
    },
  })

  const emit = defineEmits(['click', 'mouseover', 'mouseout'])

  const button_class = computed(() => {
    let style = ''
    if (props.enabled === false) {
      style += ' disabled cursor-not-allowed '
    } else {
      style += ' cursor-pointer '
    }
    if (props.type === 'primary') {
      if (props.active === false) {
        style +=
          'text-' + props.color + '-2 bg-' + props.color + '-3 border border-' + props.color + '-3 ' + props.padding
      } else {
        style +=
          'text-' + props.color + '-3 bg-' + props.color + '  border border-' + props.color + ' ' + props.padding
      }
    } else if (props.type === 'secondary') {
      if (props.enabled === false) {
        style +=
          'bg-' + props.color + '-3 border border-' + props.color + ' text-' + props.color + '-2 ' + props.padding
      } else if (props.active === false) {
        style += ' bg-transparent border border-' + props.color + '-2 text-' + props.color + '-2 ' + props.padding
      } else {
        style +=
          ' bg-transparent border border-' +
          props.color +
          ' text-' +
          props.color +
          ' hover:text-' +
          props.color +
          '-2' +
          ' hover:border-' +
          props.color +
          '-2 focus:text-' +
          props.color +
          ' focus:border-' +
          props.color +
          ' ' +
          props.padding
      }
    } else if (props.type === 'tertiary') {
      if (props.active === false) {
        style += 'text-' + props.color + '-3 ' + props.padding
      } else {
        style += 'text-' + props.color + ' ' + props.padding
      }
    } else if (props.type === 'icon') {
      if (props.active === false) {
        style += 'text-' + props.color + '-3 bg-' + props.color + '-2 w-8 h-8 justify-center flex items-center'
      } else {
        style += 'bg-' + props.color + ' text-white hover:shadow-none w-8 h-8 justify-center flex items-center'
      }
    }
    return style
  })

  const icon_class = computed(() => {
    if (props.action) {
      if (props.icon && props.icon_position === 'left') return props.icon + ' mr-2'
      if (props.icon && props.icon_position === 'right') return props.icon + ' ml-2'
    }
    return props.icon
  })

  function roundedClass() {
    if (props.type === 'icon' && !props.rounded.length) {
      return 'rounded-full'
    } else if (!props.rounded.length) {
      return 'rounded-md'
    } else {
      return props.rounded
    }
  }
</script>
<template>
  <div class="text-white">
    <h1>Debug</h1>
    <pre>{{ websocketEvents }}</pre>
  </div>
</template>

<script>
export default {
    data: () =>({
        websocketEvents: [],
    }),

    mounted() {
      window.Echo.connector.pusher.connection.bind('state_change', (states) =>
        this.websocketEvents.push({
          date: (new Date),
          ...states,
        })
      )
    }
}
</script>

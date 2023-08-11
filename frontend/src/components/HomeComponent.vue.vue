<template>
    <div>
        <h1>HomeComponent</h1>
        <button >로그인</button>
        <br>
        <button >메인</button>
        {{ $store.state.token }}
    </div>
</template>
<script>
export default {
    name: 'HomeComponent',
}
</script>
<style>
    
</style>
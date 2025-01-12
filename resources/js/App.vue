<template>
    <header>
        <nav class="primary-nav">
            <RouterLink :to="{name: 'home'}" class="primary-nav__link">Energy Data</RouterLink>
            <RouterLink :to="{name: 'installations'}" class="primary-nav__link">Installations</RouterLink>
        </nav>

    </header>
    <main>
        <RouterView/>
    </main>
</template>

<style>
.primary-nav {
    display: flex;
}
.primary-nav__link {
    padding: 1rem;
    text-decoration: none;
    color: #aaa;
    font-size: 1.6rem;
    border-bottom: .2rem solid #aaa;
    transition: all .3s ease;

    &:not(.router-link-active) {
        &:hover {
            color: #000;
            border-color: #000
        }
    }

}

.router-link-active {
    color: #009879;
    border-color: #009879;
}
</style>

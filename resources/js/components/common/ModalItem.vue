<template>
    <div>

        <div class="moodal" ref="moodal1" id="moodal1"
         data-animation="slideInOutLeft"
        >
            <div :class="`moodal-dialog  bg-${alertFormat}`">
                <header>
                    {{title}}
                    <button class="close-moodal" aria-label="close moodal" data-close>
                        X
                    </button>
                </header>
                <section class="moodal-content">
                    <p>
                        {{message}}
                    </p>
                </section>
                <footer class="moodal-footer"></footer>
            </div>
        </div>



        <div class="moodal" ref="moodal2" id="moodal2"
         data-animation="mixInAnimations"
        >
            <div :class="`moodal-dialog bg-${alertFormat}`">
                <header>
                    {{title}}
                    <button class="close-moodal" aria-label="close moodal" data-close>
                        X
                    </button>
                </header>
                <section class="moodal-content">
                    <p>{{message}}</p>
                </section>
                <footer class="moodal-footer"></footer>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
    export default {
        props:[

        ],
        computed:{
            ...mapState({
                status:state=>state.alertActionModule.status,
                open:state=>state.alertActionModule.open,
                message:state=>state.alertActionModule.message,
                title:state=>state.alertActionModule.title
            }),
            alertFormat(){
                if(this.status=== 'successful'){
                    return 'successfully';
                }
                else if(this.status === 'failed')
                {
                    return 'failed'
                }
                else{
                    return '';
                }
            }
        },
        methods:{
            openModal(){
                if(this.status === 'successful'){
                    const isVisible = "is-visible";
                    const moodalId = "moodal2"
                    let that = this.$el;
                    let Elem = that.querySelector(`#${moodalId}`);
                    Elem.classList.add(isVisible);
                }
                else if(this.status === 'failed')
                {
                    const isVisible = "is-visible";
                    const moodalId = "moodal2"
                    let that = this.$el;
                    let Elem = that.querySelector(`#${moodalId}`);
                    Elem.classList.add(isVisible);
                }

            },
            closeModal(){

                const isVisible = "is-visible";
                let that = this.$el;
                if(that.querySelector(".moodal.is-visible"))
                that.querySelector(".moodal.is-visible").classList.remove(isVisible);

            }
        },
        mounted(){
            if(this.open){
                this.openModal();
            }

            const openEls = this.$el.querySelectorAll("[data-open]");
            const closeEls = this.$el.querySelectorAll("[data-close]");

            const isVisible = "is-visible";
            const that = this.$el;
            for(const el of openEls){
                el.addEventListener("click",function(){
                    const moodalId = this.dataset.open;
                    let totalElem = that.querySelector(`#${moodalId}`);
                    totalElem.classList.add(isVisible);
                });
            }

            for(const el of closeEls){
                el.addEventListener("click",function(){
                    this.parentElement.parentElement.parentElement.classList.remove(isVisible);

                });
            }

            that.addEventListener("keyup",e=>{
                if(e.key == "Escape" && that.querySelector(".moodal.is-visible")){

                    that.querySelector(".moodal.is-visible").classList.remove(isVisible);
                }
            })

            that.addEventListener("click",e=>{
                if(e.target === that.querySelector(".moodal.is-visible")){
                    that.querySelector(".moodal.is-visible").classList.remove(isVisible);

                }
            })

        },
        watch:{
            open(val){
                if(val){
                    this.openModal();
                }else{
                     this.closeModal();
                }

            }
        }

    }
</script>

<style>

:root{
    --lightgray:#efefef;
    --blue:steelblue;
    --white:#fff;
    --black:rgba(0,0,0,0.8);
    --bounceEasing:cubic-bezier(0.51,0.92,0.24,1.15);
}
*{
    padding:0;
    margin: 0;
}
a{
    color:inherit;
    text-decoration:none;
}
button{
    cursor: pointer;
    background: transparent;
    border: none;
    outline: none;
    font-size: inherit;
}

.btn-group{
    text-align: center;
}
.open-moodal{
    font-weight: bold;
    color:var(--white);
    background:var(--blue);
    padding: 0.75rem 1.75rem;
    margin-bottom: 1rem;
    border-radius: 5px;
}
.moodal {
    position: fixed;
    top:0;
    right:0;
    bottom:0;
    left:0;
    display:flex;
    align-items: center;
    justify-content: center;
    padding:1rem;
    background: var(--black);
    cursor: pointer;
    visibility: hidden;
    opacity: 0;
    transition: all 0.35s ease-in;
}
.moodal.is-visible{
    visibility: visible;
    opacity: 1;
}
.moodal-dialog{
    position: relative;
    max-width: 800px;
    max-height: 80vh;
    border-radius: 5px;
    background: var(--white);
    overflow: auto;
    cursor: default;
}
.moodal-dialog > * {
    padding:1rem;
}
.moodal-header, .moodal-footer{
background: var(--lightgray);
}
.moodal-header{
    display: flex;
    align-items: center;
    justify-content: center;
}
.moodal-header .close-moodal{
    font-size: 1.5rem;
}
.moodal p + p{
    margin-top: 1rem;
}
[data-animation] .moodal-dialog {
    opacity: 0;
    transition: all 0.5s var(--bouceEasing);
}
[data-animation].is-visible .moodal-dialog {
    opacity: 1;
    transition-delay: 0.2s;
}
[data-animation="slideInOutDown"] .moodal-dialog {
    transform: translateY(100%);
}
[data-animation="slideInOutTop"] .moodal-dialog {
    transform: translateY(-100%);
}
[data-animation="slideInOutLeft"] .moodal-dialog {
    transform: translateX(-100%);
}
[data-animation="slideInOutRight"] .moodal-dialog {
    transform: translateX(100%);
}
[data-animation="zoomInOut"] .moodal-dialog {
    transform: scale(0.2);
}
[data-animation="rotateInOutDowm"] .moodal-dialog {
    transform-origin: top left;
    transform: rotate(-1turn);
}
[data-animation="mixInAnimations"].is-visible .moodal-dialog {
   animation:mixInAnimations 2s 0.2s linear forwards;
}

[data-animation="slideInOutDown"].is-visible .moodal-dialog,
[data-animation="slideInOutTop"].is-visible .moodal-dialog,
[data-animation="slideInOutLeft"].is-visible .moodal-dialog,
[data-animation="slideInOutRight"].is-visible .moodal-dialog,
[data-animation="zoomInOut"].is-visible .moodal-dialog,
[data-animation="rotateInOutDown"].is-visible .moodal-dialog{
    transform: none;
}

@keyframes mixInAnimations {
    0% {
        transform: translateX(-100%);
    }
    10% {
        transform: translateX(0);
    }
    20% {
        transform: rotate(0);
    }
    30% {
        transform: rotate(-20deg);
    }
    40% {
        transform: rotate(15deg);
    }
    50% {
        transform: rotate(-15deg);
    }
    60% {
        transform: rotate(10deg);
    }
    70% {
        transform: rotate(-10deg);
    }
    80% {
        transform: rotate(5deg);
    }
    90% {
        transform: rotate(-5deg);
    }
    100% {
        transform: rotate(0deg);
    }
}
.bg-successfully,.moodal-header, .moodal-footer {
    background: rgba(6, 134, 23, 0.8);
    color: #fff;
}
.bg-successfully .close-moodal{
    background: rgba(6, 134, 23, 0.4);
    color:var(--white);
}
.bg-failed .moodal-header, .moodal-footer{
    background: rgba(228, 18, 29, 0.5);
    color: var(--white);
}
.bg-failed .close-moodal{
    background: rgba(228, 18, 29, 0.4);
    color:var(--white);
}

</style>

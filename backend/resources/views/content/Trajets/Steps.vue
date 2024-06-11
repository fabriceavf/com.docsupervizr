<template>
    <div>
        <div class="container dataBlock">
            <span class="titre">Avancer tous droit</span>
            <span class="sous-titre">pendant quelque instant jusqu'a voir</span>


            <div class="selectDecision">

                <div class="destinationpossibles">
                    <div class="destinationpossible">

                        <span class="sous-titre-2">1-Devant vous  </span>
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-building"></i></div>
                        <div class="bas">batiment</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-road"></i></div>
                        <div class="bas">Route</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="bas"> cul de sac</div>
                    </div>
                </div>
            </div>
            <div class="selectDecision">
                <div class="destinationpossibles">
                    <div class="destinationpossible">
                        <span class="sous-titre-2">2-A votre gauche  </span>
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-building"></i></div>
                        <div class="bas">batiment</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-road"></i></div>
                        <div class="bas">Route</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="bas"> cul de sac</div>
                    </div>
                </div>
            </div>
            <div class="selectDecision">
                <div class="destinationpossibles">
                    <div class="destinationpossible">
                        <span class="sous-titre-2">3-A votre droite   </span>
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-building"></i></div>
                        <div class="bas">batiment</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-road"></i></div>
                        <div class="bas">Route</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="bas"> cul de sac</div>
                    </div>
                </div>
            </div>

            <span class="titre">Et lorsque vous etes la </span>
            <h6>

            </h6>
            <div class="selectDecision">
                <div class="destinationpossibles">
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-building"></i></div>
                        <div class="bas">allez droite</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-road"></i></div>
                        <div class="bas">Faite tout droit</div>
                    </div>
                    <div class="destinationpossible">
                        <div class="haut"></div>
                        <div class="centre"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        <div class="bas"> prenez a droite</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    name: "Steps",

    data() {
        return {
            errors: [],
            isLoading: false,
            form: {

                id: "",

                libelle: "",

                depart: "",

                arrive: "",

                description: "",

                extra_attributes: "",

                creat_by: "",

                deleted_at: "",

                created_at: "",

                updated_at: "",
            }
        }
    },
}
</script>

<style scoped>
.titre {
    text-align: center;
    font-weight: bold;
    color: black;
    font-size: 20px;
}

.sous-titre {
    text-align: center;
}

.dataBlock {
    box-shadow: rgba(0, 0, 0, 0.24) 2px 1px 9px;
    width: 98%;
    margin: 10px auto;
    padding: 30px;
    border: 1px solid #04040438;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.moyenDeDeplacements {
    display: flex;
    position: relative;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    gap: 15px;
}

.moyenDeDeplacement {
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    border-radius: 5px;
    border: 1px solid #b7b7b7;
    padding: 2px 15px;
    text-align: center;
    cursor: pointer
}

.destinationpossibles {
    display: flex;
    position: relative;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    gap: 15px;
    padding: 5px;
    padding-top: 5px;
    padding-top: 25px;
}

.sous-titre-2 {
    position: absolute;
    top: 0;
}

.destinationpossible {
    justify-content: center;
    border-radius: 5px;
    border: 1px solid #b7b7b7;
    padding: 5px 15px;
    text-align: center;
    cursor: pointer;
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.destinationpossible:hover, .moyenDeDeplacement:hover {
    border: 1px solid green;
    color: green
}

.haut {
    font-size: 11px;
    display: none
}

/* .bas{*/
/*    font-size: 11px;*/
/*     display:none*/
/*}*/
</style>

<template>
    <div class="container" style="background-color: white;">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user fa-2x"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars fa-2x"></i></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Личный кабинет</a>
                    <a class="dropdown-item" href="/history">История изменений</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/">Выход</a>
                </div>
            </li>
        </ul>
        <div>
            <div class="container-fluid">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active tab-link" data-toggle="tab" href="#incomes">Поставки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" data-toggle="tab" href="#deals">Договоры</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" data-toggle="tab" href="#details">Детали</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" data-toggle="tab" href="#givers">Поставщики</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" data-toggle="tab" href="#detail_cards">Учётные карточки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab-link" data-toggle="tab" href="#detail_dict">Словарь деталей</a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <income-component></income-component>
                    <deals-component></deals-component>
                    <details-component></details-component>
                    <givers-component></givers-component>
                    <detail-cards-component></detail-cards-component>
                    <detail-dict-component></detail-dict-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import IncomeComponent from "../tabs/IncomeComponent";
import DealsComponent from "./DealsComponent";
import DetailsComponent from "../tabs/DetailsComponent";
import GiversComponent from "../tabs/GiversComponent";
import DetailCardsComponent from "../tabs/DetailCardsComponent";
import DetailDictComponent from "../tabs/DetailDictComponent";

export default {
    name: 'App',
    components: {
        IncomeComponent,
        DealsComponent,
        DetailsComponent,
        GiversComponent,
        DetailCardsComponent,
        DetailDictComponent
    },
}
</script>

<style scoped>
    a {
        color: #666666;
    }
    a:hover {
        color: #9152f8;
    }
</style>

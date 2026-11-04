<?php

namespace Database\Seeders;

use App\Models\Cadastro;
use Illuminate\Database\Seeder;

class CadastroSeeder extends Seeder
{
    public function run(): void
    {
        Cadastro::truncate();

        $eta = [
            'CONTINENTAL SHOPPING',
            'AEROPORTO INTERNACIONAL DE SAO PAULO - GUARULHOS',
            'ALLERGAN PRODUTOS FARMACEUTICOS',
            'ALPHAVILLE TENIS CLUBE',
            'AMERICA',
            'ANHEMBI MORUMBI',
            'ARCOR DO BRASIL BRAGANCA',
            'ARCOR DO BRASIL RIO DAS PEDRAS',
            'BANCO BRADESCO S.A (AGUA)',
            'BRASCAN CENTURY',
            'BRAZILIAN FINANCIAL CENTER',
            'CANTAREIRA EMPREENDIMENTOS',
            'CANTAREIRA EMPREENDIMENTOS AGUA DE CHUVA',
            'CATALENT',
            'CATARINA FASHION OUTLET',
            'CENTRO EMPRESARIAL DO ACO',
            'CENU',
            'CEPARNCO',
            'CITIBANK',
            'CLUBE IPE',
            'CLUBE PAINEIRAS',
            'CLUBE PINHEIROS',
            'COND E TOWER',
            'COND VILLA LOBOS',
            'COND. COMPLEXO MADEIRA',
            'COND. EDIFICIO ELUMA',
            'COND. SAO LUIZ',
            'COND. TOP CENTER',
            'COND. VILLA LOBOS OFFICE PARK',
            'CONDOMINIO DO SHOPPING FREI CANECA',
            'CONDOMINIO PATIO VICTOR MALZONI',
            'CONDOMÍNIO SALVADOR SHOPPING',
            'WTC',
            'CONDOMINIO WTORRE NACOES UNIDAS',
            'CRYOVAC BRASIL (JAGUARIUNA)',
            'DAN VIGOR INDUSTRIA E COMERCIO DE LATICINIOS',
            'ESTANPLAZA FUNCHAL',
            'EUROFARMA',
            'FARIA LIMA FINANCIAL CENTER',
            'FARIA LIMA TOWER',
            'FUNDACAO CASPER LIBERO',
            'GOLDEN SHOP. S. BERNARDO',
            'GRAND PLAZA SHOPPING',
            'HOSPITAL ALEMÃO OSWALDO CRUZ',
            'HOSPITAL CARLOS CHAGAS',
            'HOSPITAL DA BAHIA',
            'HOSPITAL PAULISTANO',
            'HOSPITAL SAMARITANO',
            'HOSPITAL SANTA IZABEL',
            'HOSPITAL SAO CAMILO IPIRANGA',
            'HOSPITAL SAO CAMILO POMPEIA',
            'HOSPITAL SAO CAMILO SANTANA',
            'HOSPITAL VITORIA',
            'INAPEL',
            'INDUSTRIA FRESENIUS MEDICAL CARE',
            'INDUSTRIAS ANHEMBI S/A',
            'INFINITY TOWER',
            'ITM CENTRO TEXTIL',
            'COND. TAMBORÉ JAGUARIUNA',
            'LIOTECNICA (AGUA)',
            'LITORAL PLAZA SHOPPING',
            'MACKENZIE',
            'MOOCA PLAZA SHOPPING',
            'MORUMBI TOWER',
            'NEXT HOSPITAL SAO BERNARDO',
            'OFFICE TAMBORE',
            'PIRELLI - ÁGUA INDUSTRIAL',
            'PIRELLI - ÁGUA POTÁVEL',
            'POLO SHOPPING',
            'PORTO SEGURO',
            'PROLOGIS (PERNAMBUCANAS)',
            'PROLOGIS (MERCADO LIVRE)',
            'PROLOGIS CCP EMPREENDIMENTOS IMOBILIARIOS LTDA',
            'QUARTEIRAO SAO LUIZ',
            'ROQUETTE',
            'ROYAL PALM HALL',
            'ROYAL PALM PLAZA',
            'SAINT GOBAIN ABRASIVOS',
            'SANTOS BRASIL',
            'SAO JUDAS',
            'SEKURIT',
            'SHOP. GRANJA VIANA',
            'SHOP. IGUATEMI CAMPINAS',
            'SHOP. IGUATEMI SAO JOSE DO RIO PRETO',
            'SHOP. IGUATEMI SP',
            'SHOP. TAMBORE',
            'SHOPPING ANALIA FRANCO',
            'SHOPPING CIDADE',
            'SHOPPING IGUATEMI ALPHAVILLE',
            'SHOPPING ITAQUERA',
            'SHOPPING JK IGUATEMI',
            'SHOPPING PIRACICABA',
            'SHOPPING PLAZA SUL',
            'SHOPPING PRACA DA MOCA',
            'SHOPPING VILLA LOBOS',
            'TIEPAR PLAZA SHOPPING',
            'TOTAL QUIMICA',
            'WHEATON',
            'PORTO FELIZ',
            'IBIS',
            'IBIS BUDGET',
            'SHOPPING ABC',
            'SHOPPING D',
            'SHOPPING PENHA',
            'SHOPPING PATIO HIGIENOPOLIS',
            'HOSPITAL SALVALUS',
            'HOSPITAL AC CAMARGO',
            'CONDOMINIO QUINTA DA BARONEZA',
            'CLUBE HÍPICO DE SANTO AMARO',
        ];

        $epar = [
            'EXPO CENTER NORTE',
            'CONTINENTAL SHOPPING',
            'AEROPORTO DE BRASILIA',
            'CANTAREIRA EMPREENDIMENTOS S/A',
            'CBOP CASTELLO BRANCO OFFICE PARK',
            'CATARINA FASHION OUTLET',
            'SHOPPING PARQUE D. PEDRO',
            'CONDOMINIO PATIO VICTOR MALZONI',
            'CONDOMINIO SALVADOR SHOPPING',
            'WTC',
            'ED. EVOLUTION CORPORATE',
            'GRAND PLAZA SHOPPING',
            'ITAU UNIBANCO - CEIC',
            'ITAU UNIBANCO - EUDORO',
            'JUNDIAI SHOPPING',
            'UNIAO QUIMICA - INOVAT',
            'LUXOTTICA CAMPINAS',
            'LUXOTTICA SUMARE',
            'MOOCA PLAZA SHOPPING',
            'SHOPPING CENTER ELDORADO',
            'PARKSHOPPING - BRASILIA',
            'SAO BERNARDO PLAZA SHOPPING',
            'SHOP. IGUATEMI CAMPINAS',
            'SHOPPING ABC',
            'SHOPPING ANALIA FRANCO',
            'SHOPPING CENTER NORTE',
            'SHOPPING CIDADE',
            'SHOPPING D',
            'SHOPPING GALERIA',
            'SHOPPING GRANJA VIANA',
            'SHOPPING IGUATEMI ALPHAVILLE',
            'SHOPPING IGUATEMI RIBEIRAO',
            'SHOPPING ITAQUERA',
            'SHOPPING JARDIM SUL',
            'SHOPPING JK IGUATEMI',
            'SHOPPING MAIS',
            'SHOPPING P. BANDEIRAS',
            'SHOPPING PENHA',
            'SHOPPING PLAZA SUL',
            'SHOPPING PRAÇA DA MOÇA',
            'SHOPPING TAMBORE',
            'SHOPPING VILLA LOBOS',
            'HOSPITAL ALVORADA',
            'TIEPAR PLAZA SHOPPING',
            'PLAZA SHOPPING NITEROI',
            'BRISTOL INTERNATIONAL AIRPORT HOTEL DE GUARULHOS',
            'CONDOMINIO QUINTA DA BARONEZA',
        ];

        $agora = now();
        $registros = [];

        foreach ($eta as $nome) {
            $registros[] = [
                'nome' => $this->normalizar($nome),
                'tipo' => 'ETA',
                'created_at' => $agora,
                'updated_at' => $agora,
            ];
        }

        foreach ($epar as $nome) {
            $registros[] = [
                'nome' => $this->normalizar($nome),
                'tipo' => 'EPAR',
                'created_at' => $agora,
                'updated_at' => $agora,
            ];
        }

        foreach (array_chunk($registros, 100) as $lote) {
            Cadastro::insert($lote);
        }

        $this->command->info('Cadastros criados: ' . Cadastro::count());
    }

    private function normalizar(string $nome): string
    {
        $nome = trim($nome);
        $nome = preg_replace('/\s+/', ' ', $nome);

        return rtrim($nome, " -");
    }
}

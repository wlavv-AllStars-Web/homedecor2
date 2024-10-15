{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
{extends file='page.tpl'}

{block name='page_title'}
  {$cms.meta_title}
{/block}

{block name='page_content_container'}
  <section id="content" class="page-content page-cms page-cms-{$cms.id}">

    {block name='cms_content'}
      {if $cms.id == 2}
        <div class="privacy-cms">
          <h3>{l s="Política de Privacidade" d="Shop.Theme.Privacy"}</h3>
          <p>{l s="A Casa de Campo respeita a sua privacidade e agradece a confiança que deposita em nós. Nesta Política de Privacidade explicamos quem somos, para que finalidades podemos usar os seus dados, como os tratamos, com quem os partilhamos, bem como as formas de entrar em contacto connosco e de exercer os seus direitos." d="Shop.Theme.Privacy"}</p>
          <p>{l s="Somos transparentes sobre aquilo que fazemos com os seus dados pessoais, para que compreenda as implicações das utilizações que realizamos ou os direitos que tem em relação aos seus dados. Colocamos ao seu dispor de forma permanente toda a informação incluída nesta Política de Privacidade que pode consultar quando quiser e, além disso, também irá encontrar informação acerca de cada tratamento dos seus dados pessoais conforme for interagindo connosco." d="Shop.Theme.Privacy"}</p>

          <h3>{l s="Alguns nomes que utilizaremos nesta Política de Privacidade" d="Shop.Theme.Privacy"}:</h3>
          <ul>
            <li>{l s="Quando falamos da nossa Plataforma, referimo-nos em geral a qualquer dos canais ou meios, digitais ou em pessoa, que utilizou para interagir connosco." d="Shop.Theme.Privacy"}</li>
          </ul>

          <h3>{l s="Os principais são" d="Shop.Theme.Privacy"}:</h3>
          <ul>
            <li>{l s="O nosso site," d="Shop.Theme.Privacy"}<a href="#">www.acasadecampo.pt</a></li>
            <li>{l s="Pessoalmente, na nossa Loja Física da Casa de Campo em Portugal." d="Shop.Theme.Privacy"}</li>
          </ul>

          <p>{l s="Utilizaremos os seus dados (recolhidos online e/ou pessoalmente), entre outras finalidades, para gerir o seu registo como utilizador, gerir a compra de produtos ou serviços, responder às suas questões, assim como para, se assim desejar, lhe enviarmos as nossas comunicações personalizadas." d="Shop.Theme.Privacy"}</p>

          <p>{l s="Estamos legitimados para tratar os seus dados por diferentes fundamentos. O principal é que precisamos de os tratar para a execução do contrato que aceita celebrar connosco ao fazer uma compra, ou mesmo para obtenção de orçamento (obrigações pré-contratuais) ou até mesmo para usufruir de algum dos nossos serviços ou funcionalidades, embora haja outras razões que nos legitimam para os utilizar, como o interesse em responder às suas perguntas ou o consentimento que nos concede para lhe enviarmos as nossas newsletters, entre outras." d="Shop.Theme.Privacy"}</p>

          <p>{l s="Partilharemos os seus dados com prestadores de serviços que nos prestam assistência ou suporte, quer sejam da Casa de Campo, quer sejam colaboradores externos com os quais celebramos um acordo, estando os mesmos situados em Portugal. Tem direito a aceder, retificar ou apagar os seus dados pessoais. Em alguns casos também tem outros direitos, por exemplo, de se opor a utilizarmos os seus dados ou direito a portá-los, como explicamos pormenorizadamente abaixo, podendo a qualquer momento solicitar a eliminação dos seus dados pessoais para o correio eletrónico, " d="Shop.Theme.Privacy"}<strong>info@acasadecampo.pt</strong>.</p>

          <p>{l s="Consulte a nossa Política de Privacidade completa para compreender devidamente a forma como utilizaremos os seus dados pessoais e os direitos que tem em relação aos mesmos." d="Shop.Theme.Privacy"}</p>

          <h3>{l s="Identificação do responsavel pelo tratamento de dados" d="Shop.Theme.Privacy"}:</h3>
          
          <ul class="tratamento-dados">
            <li><strong>{l s="Empresa" d="Shop.Theme.Privacy"}: </strong><span>{l s="Soumad - Comércio de Madeiras e Derivados, Lda. (doravante “A Casa de Campo”)" d="Shop.Theme.Privacy"}</span></li>
            <li><strong>{l s="Séde" d="Shop.Theme.Privacy"}: </strong><span>{l s="Rua de Favais, n.9, Arão | 4930-015 Valença" d="Shop.Theme.Privacy"}</span></li>
            <li><strong>{l s="NIF" d="Shop.Theme.Privacy"}: </strong><span>{l s="504 884 298" d="Shop.Theme.Privacy"}</span></li>
            <li><strong>{l s="Contacto" d="Shop.Theme.Privacy"}: </strong><span>{l s="+351 926 024 685 (chamada para a rede móvel nacional)" d="Shop.Theme.Privacy"}</span></li>
            <li><strong>{l s="Encarregado da Proteção de Dados" d="Shop.Theme.Privacy"}: </strong><span>info@acasadecampo.pt</span></li>
          </ul>

          <h3>{l s="Porque tratamos os seus dados pessoais" d="Shop.Theme.Privacy"}:</h3>

          <p>{l s="Dependendo das finalidades para as quais tratamos os seus dados em cada momento, tal como explicado acima, necessitamos de tratar uns ou outros dados que, em geral, serão, consoante o caso, os seguintes" d="Shop.Theme.Privacy"}:</p>
          <ul>
            <li>
            {l s="os seus dados de identificação (por exemplo, o seu nome, morada, contribuinte fiscal, dados de contacto, etc.);" d="Shop.Theme.Privacy"}
            </li>
            <li>
            {l s="Informação económica e transacional (por exemplo, os seus dados financeiros no caso de pretender pedido de financiamento para aquisição dos nossos produtos.);" d="Shop.Theme.Privacy"}
            </li>
            <li>
            {l s="Informação comercial (por exemplo, se subscreveu a nossa newsletter). Dados sobre os seus gostos e preferências." d="Shop.Theme.Privacy"}
            </li>
          </ul>

          <p>{l s="Recorde que, ao pedirmos que preencha os seus dados pessoais para dar-lhe acesso a alguma funcionalidade ou serviço da Plataforma, marcaremos alguns campos como obrigatórios, pois são dados que necessitamos para lhe poder prestar o serviço ou dar-lhe acesso às funcionalidades em questão. Por favor, tenha em conta que se decidir não nos fornecer esses dados, poderá não poder completar o seu registo como utilizador ou poderá não conseguir usufruir esses serviços ou funcionalidades. Dependendo de como interaja com a nossa Plataforma, isto é, dependendo dos serviços, produtos ou funcionalidades que pretender usufruir, trataremos os seus dados pessoais para as seguintes finalidades" d="Shop.Theme.Privacy"}:</p>

          <h3>{l s="Finalidade do tratamento de dados pessoais" d="Shop.Theme.Privacy"}</h3>

          <h4>{l s="Para atender às solicitações ou pedidos que realizar através dos canais de Apoio ao Cliente. Só tratamos os dados pessoais que sejam estritamente necessários para gerir ou resolver a sua solicitação ou pedido. Esta finalidade inclui o tratamento dos seus dados, principalmente, para" d="Shop.Theme.Privacy"}:</h4>

          <ul>
            <li>
              <p>
              {l s="Na medida em que ao consentir receber novidades e comunicações da Casa de Campo, trataremos os seus dados pessoais para gerir tal pedido, incluindo para envio de informação personalizada acerca dos nossos produtos ou serviços através de diversos meios (como o correio eletrónico, MMS ou SMS)." d="Shop.Theme.Privacy"}
              </p>
            </li>
            <li>
              <p>
              {l s="Neste sentido, tenha em conta que este tratamento de dados não pressupõe qualquer análise do seu perfil de utilizador ou cliente para determinar quais são as suas preferências e, portanto, quais são os produtos e serviços mais adequados no seu estilo quando lhe enviamos informação." d="Shop.Theme.Privacy"}
              </p>
            </li>
            <li>
              <p>
              {l s="Recorde que pode solicitar o cancelamento de tal serviço a qualquer momento e sem nenhum custo, bastando para tal remeter-nos um e-mail para " d="Shop.Theme.Privacy"}info@acasadecampo.pt.
              </p>
            </li>
          </ul>

          <h4>{l s="Para fins de marketing." d="Shop.Theme.Privacy"}</h4>

          <ul>
            <li>
              <p>
              {l s="Realizar ações promocionais (por exemplo, para a organização de feiras, concursos ou para envio da sua lista de artigos guardados para o endereço de correio eletrónico que nos indicar)." d="Shop.Theme.Privacy"}
              </p>
            </li>
            <li>
              <p>
              {l s="Ao participar em alguma ação promocional, autoriza-nos a tratar os dados que nos disponibilizou em função de cada ação promocional e a comunicá-los através de diversos meios como redes sociais ou na própria Plataforma. Em cada ação promocional em que participar terá disponíveis os termos e condições onde lhe daremos informação mais detalhada sobre o tratamento dos seus dados pessoais." d="Shop.Theme.Privacy"}
              </p>
            </li>
            <li>
              <p>
              {l s="Informamos que os seus dados pessoais para os presentes fins serão conservados durante 10 anos após a obtenção do consentimento, podendo, conforma acima referenciado, solicitar o apagamento dos seus dados para o e-mail para info@acasadecampo.pt." d="Shop.Theme.Privacy"}
              </p>
            </li>
            
          </ul>

          <h4>{l s="Análise de funcionalidade e de qualidade para melhorar os nossos serviços." d="Shop.Theme.Privacy"}</h4>

          <ul>
            <li>
              <p>{l s="Se aceder à nossa Plataforma/site, informamos que não trataremos os seus dados de navegação para fins analíticos e estatísticos, isto é, para entender de que forma os utilizadores interagem com a nossa Plataforma e assim sermos capazes de melhorar a mesma. Além disso, em determinadas ocasiões poderemos realizar ações e inquéritos de qualidade destinados a conhecer o grau de satisfação dos nossos clientes e utilizadores e detetar as áreas em que podemos melhorar, contudo, será informado detalhadamente do eventual tratamento dos seus dados pessoais." d="Shop.Theme.Privacy"}</p>  
            </li>
          </ul>

          <h3>{l s="Qual é o fundamento de legitimidade para o tratamento dos seus dados?" d="Shop.Theme.Privacy"}</h3>

          <h4>{l s="O fundamento jurídico que nos permite tratar os seus dados pessoais também depende da finalidade para a qual os tratamos, conforme vamos explicar" d="Shop.Theme.Privacy"}:</h4>

          <ul>

            <li>
              <h5>{l s="Gerir o seu registo como utilizador do site/plataforma" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="O tratamento dos seus dados é necessário de acordo com os termos que regulam a utilização da Plataforma. Por outras palavras, para efetuar um pedido de contacto na Plataforma/site, necessitamos de tratar os seus dados pessoais, pois em caso contrário não poderíamos gerir o seu registo nem satisfazer os seus pedidos. No caso de decidir utilizar o nosso site ou um acesso através de uma rede social, o motivo pelo qual estamos legitimados para tratar os seus dados é o consentimento que concede no momento de autorizar a cessão dos seus dados através da rede social ou site. O tratamento dos seus dados é necessário para a celebração do contrato de compra e venda ou de prestação de serviços consigo. Alguns tratamentos de dados relacionados com o processo de compra só serão ativados porque o solicita ou o autoriza, como é o caso do armazenamento dos dados de pagamento (documentos contabilísticos) para obtenção de financiamento." d="Shop.Theme.Privacy"}</p>
            </li>

            <li>
              <h5>{l s="Desenvolvimento, cumprimento e execução do contrato de compra e venda ou de serviços" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Nestes casos, o fundamento para tratarmos os seus dados é o seu próprio consentimento. Consideramos que temos um interesse legítimo para realizar as verificações necessárias para detetar e prevenir possíveis fraudes quando realiza uma compra. Entendemos que o tratamento destes dados é positivo para todas as partes que intervêm quando se realiza o pagamento de uma compra e, em particular para si, pois permite-nos tomar medidas para o proteger contra tentativas de fraude realizadas por terceiros. Consideramos que temos um interesse legítimo para responder aos pedidos ou perguntas que nos fizer através dos diversos meios de contacto existentes. Entendemos que o tratamento destes dados também é benéfico para si, na medida em que nos permite assisti-lo adequadamente e responder aos pedidos realizados, fazer inquéritos de satisfazer e até apresentar produtos que poderão satisfazer as suas necessidades." d="Shop.Theme.Privacy"}</p>
            </li>

            <li>
              <h5>{l s="Apoio ao Cliente" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Quando nos contatar, em particular, para a gestão de incidentes relacionados com a sua encomenda ou o produto/ serviço adquirido através do nosso site/plataforma, o tratamento dos seus dados é necessário para a celebração do contrato de compra e venda, bem como das obrigações pré-contratuais, sendo que provém do seu consentimento. Quando o seu pedido estiver relacionado com o exercício dos direitos sobre os quais o informamos abaixo, ou com reclamações relacionadas com os nossos produtos ou serviços, o que nos legitima a tratar os seus dados é o cumprimento das nossas obrigações legais." d="Shop.Theme.Privacy"}</p>
            </li>

            <li>
              <h5>{l s="Marketing" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="O fundamento de legitimidade para tratar os seus dados para finalidades de marketing é o consentimento que livremente nos concede, por exemplo, quando aceita receber informação personalizada através de diversos meios, quando aceita os presentes termos e condições." d="Shop.Theme.Privacy"}</p>
          </li>
          </ul>

          <h3>{l s="Durante quanto tempo conservaremos os seus dados?" d="Shop.Theme.Privacy"}</h3>
          
          <h4>{l s="O prazo de conservação dos seus dados dependerá das finalidades para as quais os tratamos, conforme como se explica de seguida" d="Shop.Theme.Privacy"}</h4>
          <ul>
            <li>
              <h5>{l s="Gerir o seu registo como utilizador do site." d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Trataremos os seus dados durante o tempo em que mantiver a condição de utilizador registado (isto é, até decidir cancelar o seu registo)." d="Shop.Theme.Privacy"}</p>
            </li>
            <li>
              <h5>{l s="Desenvolvimento, cumprimento e execução do contrato de compra e venda ou serviços." d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Trataremos os seus dados durante o tempo necessário para gerir a compra dos produtos ou serviços que adquiriu, incluindo possíveis devoluções, queixas ou reclamações associadas à compra do produto ou serviço em particular, sendo que estabelecemos o período de 3 anos." d="Shop.Theme.Privacy"}</p>
            </li>
            <li>
              <h5>{l s="Apoio ao Cliente" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Trataremos os seus dados durante o tempo que for necessário para atender a sua solicitação ou pedido." d="Shop.Theme.Privacy"}</p>
            </li>
            <li>
              <h5>{l s="Marketing" d="Shop.Theme.Privacy"}</h5>
              <p>{l s="Trataremos os seus dados até cancelar a sua subscrição ou solicitar o apagamento dos seus dados remetendo-nos um e-mail para info@acasadecampo.pt a solicitar o apagamento dos seus dados no que tange ao envio de newsletters, sendo que, caso não o faça conservamos os seus dados pessoais para tal finalidade durante 10 anos. Independentemente de tratarmos os seus dados pessoais durante o tempo estritamente necessário para cumprir a finalidade correspondente, conservaremos posteriormente os mesmos devidamente guardados e protegidos durante o tempo em que puderem surgir responsabilidades decorrentes do tratamento, cumprindo a legislação vigente em cada momento. Quando cada uma das possíveis ações prescrever, apagaremos os dados pessoais." d="Shop.Theme.Privacy"}</p>
            </li>
          </ul>

          <h3>{l s="Partilhamos os seus dados com terceiros?" d="Shop.Theme.Privacy"}</h3>

          <h4>{l s="Para cumprir as finalidades indicadas na presente Política de Privacidade, é necessário darmos acesso aos seus dados pessoais a entidades da Casa de Campo e a terceiros que nos prestam apoio nos serviços que lhe proporcionamos, por exemplo" d="Shop.Theme.Privacy"}:</h4>

          <ul>
            <li><strong>{l s="Instituições financeiras;" d="Shop.Theme.Privacy"}</strong></li>
            <li><strong>{l s="Prestadores de serviços tecnológicos;" d="Shop.Theme.Privacy"}</strong></li>
            <li><strong>{l s="Prestadores e colaboradores de serviços de logística, transporte e entrega;" d="Shop.Theme.Privacy"}</strong></li>
            <li><strong>{l s="Prestadores de serviços relacionados com apoio ao cliente;" d="Shop.Theme.Privacy"}</strong></li>
            <li><strong>{l s="Parceiros e prestadores de serviços relacionados com marketing e publicidade;" d="Shop.Theme.Privacy"}</strong></li>
          </ul>

          <p>{l s="Por razões de eficiência do serviço, alguns dos prestadores poderão não pertencer à Casa de Campo, mas situam-se todos eles no Espaço Económico Europeu. Informamos que ao transferirmos os seus dados a terceiros salvaguardamos com garantias adequadas e sempre mantendo a segurança dos seus dados" d="Shop.Theme.Privacy"}:</p>

          <h3>{l s="Quais são os seus direitos quando nos fornece os seus dados" d="Shop.Theme.Privacy"}</h3>

          <p>{l s="Comprometemo-nos a respeitar a confidencialidade dos seus dados pessoais e a garantir-lhe o exercício dos seus direitos. Determinamos que pode exercer os seus direitos sem nenhum custo escrevendo-nos uma mensagem de correio eletrónico para um endereço de correio eletrónico (info@acasadecampo.pt), simplesmente indicando-nos o motivo do seu pedido e o direito que quer exercer." d="Shop.Theme.Privacy"}</p>

          <p>{l s="No caso de considerarmos necessário para o podermos identificar, podemos solicitar uma cópia de um documento identificativo. Em particular, independentemente da finalidade ou do fundamento jurídico ao abrigo do qual tratarmos os seus dados, tem direito a" d="Shop.Theme.Privacy"}:</p>

          <ul>
            <li>{l s="Pedir-nos acesso aos dados que dispomos de si." d="Shop.Theme.Privacy"}</li>
            <li>{l s="Pedir-nos que retifiquemos os dados que já dispomos." d="Shop.Theme.Privacy"}</li>
            <li>{l s="Pedir-nos que apaguemos os seus dados na medida em que já não sejam necessários para a finalidade para a qual necessitamos de continuar a tratá-los, conforme acima explicado, ou quando já não estivermos legalmente autorizados a tratá-los." d="Shop.Theme.Privacy"}</li>
            <li>{l s="Pedir-nos que cancelemos ou limitemos o tratamento dos seus dados, o que significa que em determinados casos nos possa solicitar que suspendamos temporariamente o tratamento dos dados ou que os conservemos para além do tempo necessário quando o necessitar." d="Shop.Theme.Privacy"}
            </li>
          </ul>

          <p>{l s="Se nos facultou o seu consentimento para o tratamento dos seus dados para qualquer finalidade, também tem direito a retirá-lo em qualquer momento, remetendo-nos tal pedido para o seguinte correio eletrónico: info@acasadecampo.pt. Quando a nossa legitimidade para o tratamento dos seus dados for o seu consentimento ou a execução do contrato, conforme acima se explica, também terá direito a solicitar a portabilidade dos seus dados pessoais." d="Shop.Theme.Privacy"}</p>

          <p>{l s="Isto significa que terá direito a receber os dados pessoais que nos forneceu num formato estruturado, de uso corrente e de leitura automática, para poder transmiti-los diretamente a outra entidade sem impedimento da nossa parte. Por outro lado, quando o tratamento dos seus dados se fundar no nosso interesse legítimo, também terá direito a opor-se ao tratamento dos seus dados. Por último, informamos que tem direito a apresentar uma reclamação à autoridade de controlo em matéria de proteção de dados Comissão Nacional de Proteção de Dados situa-se na: Av. D. Carlos I, 134 – 1.º 1200-651 Lisboa. Telefone: 213 928 400 Fax: 213 976 832 E-mail: geral@cnpd.pt." d="Shop.Theme.Privacy"}</p>

          <h3>{l s="Alterações à Política de Privacidade" d="Shop.Theme.Privacy"}</h3>

          <p>{l s="É possível modificarmos a informação enunciada nesta Política de Privacidade quando considerarmos adequado, podendo ser previamente notificada da sua alteração. Nesse caso, receberá uma mensagem para o seu endereço de correio eletrónico quando a alteração em questão for significativa em relação à sua privacidade, de modo a poder rever as alterações, avaliá-las e, se for o caso, opor-se cancelar algum serviço ou funcionalidade." d="Shop.Theme.Privacy"}</p>

          <h3>{l s="Informação sobre cookies" d="Shop.Theme.Privacy"}</h3>

          <p>{l s="Utilizamos cookies e dispositivos similares para facilitar a sua navegação na Plataforma, compreender como interage connosco e, em determinados casos, poder mostrar-lhe publicidade em função dos seus hábitos de navegação. Por favor, leia a nossa Política de Cookies para conhecer em maior detalhe os cookies e dispositivos similares que utilizamos, a sua finalidade e outra informação útil." d="Shop.Theme.Privacy"}</p>

        </div>
      {elseif $cms.id == 3}
        <div class="terms_conditions">
<div class="terms-img">
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
</div>
<div class="terms-list">
<p>{l s="A Casa de Campo é responsável por todos os conteúdos disponibilizados no seu website, à exceção daqueles devidamente identificados. A Casa de Campo trabalha no sentido de que toda a informação apresentada esteja isenta de qualquer erro, no entanto, no caso da ocorrência de um erro, trataremos de o corrigir logo que possível. Chamamos ainda a atenção para o facto das cores visualizadas no seu ecrã poderem não corresponder com exatidão ao produto final, já que dependem das definições do próprio computador." d="Shop.Theme.Terms"}</p>

<p>
  <strong>{l s="Direitos de autor" d="Shop.Theme.Terms"}:</strong>
  <span>{l s="As imagens e demais informações relativas aos produtos da Casa de Campo existentes neste website poderão ser divulgadas livremente, desde que devidamente assinalada a sua procedência e respeitados todos os direitos de copyright dos produtos de que a marca é titular." d="Shop.Theme.Terms"}</span>
</p>

<p>
  <strong>{l s="Confidencialidade" d="Shop.Theme.Terms"}:</strong>
  <span>{l s="Os contactos e outras informações pessoais são facultados à Casa de Campo pelos próprios, podendo estes ser tratados informaticamente de forma automática ou manual. Os dados pessoais recolhidos são necessários nos processos de encomenda e de entrega da mercadoria em casa do cliente ou para a divulgação da newsletter e campanhas da marca." d="Shop.Theme.Terms"}</span>
</p>

<p>
  <strong>{l s="Preâmbulo" d="Shop.Theme.Terms"}:</strong>
  <span>{l s="As ofertas da nossa loja online são feitas pela Casa de Campo." d="Shop.Theme.Terms"}</span>
</p>

<p>
  <strong>{l s="Identificação" d="Shop.Theme.Terms"}:</strong>
  <span>{l s="Nome: Soumad - Comércio de Madeiras e Derivados, lda" d="Shop.Theme.Terms"}</span>
  <span>{l s="Morada: Lugar do Tuído, Gandra | 4930-327 Valença" d="Shop.Theme.Terms"}</span>
  <span>{l s="Telemóvel: +351 926 024 685 | Telefone: +351 251 094 513 (chamada para a rede móvel nacional)" d="Shop.Theme.Terms"}</span>
  <span>{l s="E-mail: info@acasadecampo.pt" d="Shop.Theme.Terms"}</span>
</p>

<ol>
<li>
<h2>{l s="Fim da venda" d="Shop.Theme.Terms"}:</h2>
<p>{l s="As ofertas propostas no Site serão válidas enquanto os produtos relacionados estiverem online e enquanto houver o produto em stock." d="Shop.Theme.Terms"}</p>
</li>

<li>
<h2>{l s="Formalização da encomenda" d="Shop.Theme.Terms"}:</h2>
<p>{l s="Qualquer formulário de encomenda assinado pelo cliente através de um clique em ‘confirmar encomenda’ constituirá um compromisso irrevogável que deve ser questionado apenas nos casos listados nestes Termos e Condições Gerais de Venda." d="Shop.Theme.Terms"}</p>
</li>

<li>
  <h2>{l s="Confirmação da encomenda" d="Shop.Theme.Terms"}:</h2>
  <p>{l s="O contrato só se tornará efetivo após uma confirmação de encomenda feita pela Casa de Campo. O cliente receberá um aviso de receção por email para confirmar a encomenda incluindo todos os elementos, tais como a lista de produtos encomendados, o preço, a data de entrega e os custos de transporte." d="Shop.Theme.Terms"}</p>
  <p>{l s="A Casa de Campo reserva-se no direito de não confirmar a encomenda por qualquer razão que seja, em particular relacionadas com as regras de aquisição de produtos ou qualquer problema relativo à ordem de encomenda recebida." d="Shop.Theme.Terms"}</p>
</li>

<li>
  <h2>{l s="Preço - Fatura" d="Shop.Theme.Terms"}:</h2>
  <p>{l s="Os preços estão indicados em Euros. O comprador tem garantido o preço colocado no Site no momento da compra. O preço fixado no momento da compra é correto e não inclui os custos de entrega que são um extra. Estes custos serão indicados no momento de confirmação da encomenda. Para uma entrega dentro da EU, os preços incluem o IVA aplicável no momento da compra. O IVA está incluído no preço. Nem custos de alfândega ou IVA devem ser cobrados aquando de uma entrega dentro da EU. Qualquer variação da taxa de IVA aplicável pode afetar o preço de venda do produto no catálogo. Na eventualidade da entrega fora da EU, o cliente terá que pagar por direitos alfandegários, IVA ou qualquer outra taxa relativa à importação de produtos dentro do país de entrega. O cliente é igualmente responsável pelas formalidades relacionadas exceto noutros casos especificados. O cliente é o único responsável por verificar em que casos os produtos encomendados se referem à legislação aplicável dentro do país de entrega." d="Shop.Theme.Terms"}</p>
  <p>{l s="A fatura será emitida pela Casa de Campo. O cliente deverá indicar a morada para a qual a fatura deve ser enviada." d="Shop.Theme.Terms"}</p>
</li>

<li>
<h2>{l s="Pagamento" d="Shop.Theme.Terms"}:</h2>
<p>{l s="O preço é calculado aquando da colocação do pedido de encomenda. O cliente compromete-se a pagar o preço total dos produtos (preço do produto mais custos de entrega) conforme o estipulado no Site e igualmente a pagar, ou arranjar alguém para pagar por si os custos alfandegários, IVA ou qualquer outra taxa relativa à importação do produto no país de entrega, diretamente ao oficial alfandegário. O cliente deverá pagar pela sua encomenda com: Paypal, Cartão Bancário, Entidade e Referência Multibanco ou MBway." d="Shop.Theme.Terms"}</p>
</li>

<li>
  <h2>{l s="Registo e Proteção de dados pessoais" d="Shop.Theme.Terms"}:</h2>
  <p>{l s="Ao efetuar o registo para utilizar este website, será pedido ao Cliente que crie uma palavra-passe. O Cliente deverá mantê-la estritamente confidencial, não a revelando nem a partilhando com terceiros. O Cliente é total e exclusivamente responsável pelo uso da sua palavra-passe bem como quaisquer encomendas efetuadas com a mesma, mesmo sem o seu conhecimento. No caso de Clientes com registo, serão recolhidos os elementos necessários à realização de toda a transação comercial online e a futuros contactos que se mostrem necessários estabelecer, de maneira a assegurar o melhor serviço ao cliente." d="Shop.Theme.Terms"}</p>
  <p>{l s="O Cliente garante que os dados pessoais fornecidos são verdadeiros e exatos, e compromete-se a notificar qualquer alteração dos mesmos. Quaisquer perdas ou danos causados à loja online ou a terceiros resultantes de informação incorreta, inexata ou incompleta dos formulários de registo será da exclusiva responsabilidade do Cliente." d="Shop.Theme.Terms"}</p>
  <p>{l s="Os serviços assegurados pela Casa de Campo respeitarão sempre o previsto na Lei de Proteção de Dados Pessoais – Lei n.º 67/98, de 26 de Outubro, pelo que os dados pessoais fornecidos pelos Clientes são recolhidos pela Casa de Campo com a exclusiva finalidade de gestão da conta dos Clientes, faturação, comunicação com os Clientes, análises estatísticas e ações de marketing direto, assumindo o compromisso de privacidade e segurança no tratamento dos dados pessoais de cada Cliente." d="Shop.Theme.Terms"}</p>
  <p>{l s="O Cliente autoriza expressamente a Casa de Campo a enviar informação sobre produtos e serviços que possam ser do seu interesse, utilizando os seus dados pessoais para efeitos de marketing direto. A qualquer momento, o Cliente poderá solicitar o acesso, retificação e cancelamento dos seus dados, usando os seguintes contactos:" d="Shop.Theme.Terms"}</p>
  <p>{l s="Serviço de Apoio ao Cliente" d="Shop.Theme.Terms"}:</p>
  <ul>
    <p>{l s="IDENTIFICAÇÃO" d="Shop.Theme.Terms"}:</p>
    <ul>
      <li>{l s="Nome: Soumad - Comércio de Madeiras e Derivados, lda" d="Shop.Theme.Terms"}</li>
      <li>{l s="Morada: Lugar do Tuído, Gandra | 4930-327 Valença" d="Shop.Theme.Terms"}</li>
      <li>{l s="Telemóvel: +351 926 024 685 | Telefone: +351 251 094 513 (chamada para a rede móvel nacional)" d="Shop.Theme.Terms"}</li>
      <li>{l s="E-mail: info@acasadecampo.pt" d="Shop.Theme.Terms"}</li>
    </ul>
  </ul>
</li>


<li>
  <h2>{l s="Política de trocas e Devoluções" d="Shop.Theme.Terms"}:</h2>
  <p>{l s="O cliente não tem reconhecido o direito de desistência da compra efetuada através da página web da Casa de Campo e, portanto, se não ficar satisfeito, não poderá devolver o produto, mas sim fazer uma troca do produto. No caso dos contratos de prestação de serviços, pode haver desistência. Ambas as situações podem ocorrer num prazo máximo de catorze dias de calendário a contar:" d="Shop.Theme.Terms"}</p>
  <ul>
    <li><p>{l s="a)	Do dia da celebração do contrato, no caso dos contratos de prestação de serviços;" d="Shop.Theme.Terms"}</p></li>
    <li>
      <p>{l s="b)	Do dia em que o consumidor ou um terceiro, com exceção do transportador, indicado pelo consumidor adquira a posse física dos bens, no caso dos contratos de compra e venda, ou:" d="Shop.Theme.Terms"}</p>
      <ul>
        <li>{l s="i)	Do dia em que o consumidor ou um terceiro, com exceção do transportador, indicado pelo consumidor adquira a posse física do último bem, no caso de vários bens encomendados pelo consumidor numa única encomenda e entregues separadamente," d="Shop.Theme.Terms"}</li>
        <li>{l s="ii)	Do dia em que o consumidor ou um terceiro, com exceção do transportador, indicado pelo consumidor adquira a posse física do último lote ou elemento, no caso da entrega de um bem que consista em diversos lotes ou elementos," d="Shop.Theme.Terms"}</li>
        <li>{l s="iii)	Do dia em que o consumidor ou um terceiro por ele indicado, que não seja o transportador, adquira a posse física do primeiro bem, no caso dos contratos de entrega periódica de bens durante um determinado período;" d="Shop.Theme.Terms"}</li>
      </ul>
    </li>
  </ul>

  <p>{l s="Serviço de Apoio ao Cliente" d="Shop.Theme.Terms"}</p>
  <ul>
    <p>{l s="IDENTIFICAÇÃO:" d="Shop.Theme.Terms"}</p>
    <li>{l s="Nome: Soumad - Comércio de Madeiras e Derivados, lda" d="Shop.Theme.Terms"}</li>
    <li>{l s="Morada: Lugar do Tuído, Gandra | 4930-327 Valença" d="Shop.Theme.Terms"}</li>
    <li>{l s="Telemóvel: +351 926 024 685 | Telefone: +351 251 094 513 (chamada para a rede móvel nacional)" d="Shop.Theme.Terms"}</li>
    <li>{l s="E-mail: encomendas@acasadecampo.pt" d="Shop.Theme.Terms"}</li>
  </ul>

  <p>{l s="O direito de desistência de contrato de prestação de serviços ou troca de algum artigo, poderá ser exercido através dos canais seguintes:" d="Shop.Theme.Terms"}</p>
  <ul>
    <li>{l s="No caso da troca de artigos, através do e-mail encomendas@acasadecampo.pt explicando detalhadamente o caso, indicando o número de pedido, e anexando fotografias que comprovem o motivo do pedido de troca." d="Shop.Theme.Terms"}</li>
    <li>{l s="No caso de desistência do contrato de prestação de serviços, através do e-mail projetos@acasadecampo.pt explicando detalhadamente o caso." d="Shop.Theme.Terms"}</li>
  </ul>

  <p>{l s="Para cumprir o prazo de troca de produtos ou desistência da prestação de serviços, basta que a comunicação relativa ao exercício deste direito pela sua parte seja enviada antes do vencimento do respectivo prazo." d="Shop.Theme.Terms"}</p>
  
  <p>{l s="O contrato de prestação de serviços entra em vigor a partir da data em que for feito o pagamento da primeira prestação. Caso nos primeiros 14 dias após o pagamento ser efetivado o cliente desistir do contrato de prestação de serviços, serão canceladas as prestações acordadas dos meses posteriores, mas não será devolvido ao cliente o primeiro valor pago para iniciação de projeto." d="Shop.Theme.Terms"}</p>

  <p>{l s="O produto deve estar no mesmo estado em que foi entregue e deverá conservar a sua embalagem e etiquetagem originais, usando a mesma caixa protetora de cartão em que foi recebido para proteção do produto. Deverá igualmente conservar todos os seus acessórios e instruções de utilização. Caso a devolução não possa ser efetuada com a caixa protetora com a qual foi entregue, o cliente deverá devolvê-lo numa caixa protetora, tendo em vista fazer com que o produto seja devolvido com as máximas garantias possíveis." d="Shop.Theme.Terms"}</p>

  <p>{l s="Não será pertinente a troca dos produtos que não estejam nas mesmas condições em que o cliente os recebeu, ou que tenham sido usados para além de terem sido experimentados. Caso o produto a devolver esteja reembalado ou não se encontre na sua embalagem original e completa, sofrerá uma depreciação do seu valor inicial, que será descontado do montante a devolver. O montante reembolsado de um produto nunca poderá ser superior ao montante pago." d="Shop.Theme.Terms"}</p>

  <p>{l s="Em caso de troca, os artigos serão trocados ou será emitido ao cliente um vale no valor do pagamento efetuado pelos artigos em causa, excluindo as despesas de entrega, sem qualquer demora indevida e, em qualquer caso, o mais tardar 14 dias de calendário após a data em que sejamos informados da sua decisão de desistir deste contrato." d="Shop.Theme.Terms"}</p>

  <p>{l s="Efetuaremos a troca ou emissão de vale, utilizando o mesmo meio de envio no caso de troca de artigos e via email no caso da emissão de um vale. pagamento utilizado pelo cliente para a transação inicial, salvo se tiver disposto expressamente o contrário; No caso da troca de produtos, se for feita em loja não é submetido qualquer custo adicional, caso seja feita a troca pelo método de envio de artigos cabe ao cliente assumir todas as despesas referentes a custos de transporte. A Casa de Campo poderá reter o valor do artigo até à receção dos bens, ou até que o cliente tenha apresentado uma prova da devolução dos mesmos, dependendo da condição que se verifique em primeiro lugar. No caso da receção de um artigo danificado ou com defeito, A Casa de Campo aguarda pela receção do artigo em loja para avaliação do estado da encomenda para posteriormente decidir se a troca é efetivada." d="Shop.Theme.Terms"}</p>

  <p>{l s="A Casa de Campo recolherá, no endereço indicado pelo cliente, os bens que este desejar devolver, sem qualquer demora indevida e, em qualquer caso, o mais tardar no prazo de 14 dias de calendário a partir da data em que nos comunique a sua decisão de desistência do contrato. Considerar-se-á como cumprido o prazo se efetuar a devolução dos bens antes do fim de tal prazo;" d="Shop.Theme.Terms"}</p>

  <p>{l s="Os custos diretos de troca ficarão a cargo do cliente em qualquer caso. O custo da troca será o equivalente ao das despesas de envio sem descontos ou promoções aplicáveis. O consumidor será responsável pela diminuição do valor dos bens resultante de um manuseamento diferente do necessário para estabelecer a natureza, as características e o funcionamento dos bens. Por motivos de higiene e saúde pública, não será aceite a devolução de produtos de repouso, à exceção dos que apresentarem imperfeições de fabrico." d="Shop.Theme.Terms"}</p>

  <p>{l s="A Casa de Campo não pagará as despesas de serviços já prestados, tais como retirada de produtos usados, portes, etc. A Casa de Campo fará a troca dos artigos danificados ou não sem demoras indevidas e, em qualquer caso, antes que tenham decorrido 14 dias de calendário a contar da data em que tenha sido informado da decisão de desistência e depois de verificado o estado do produto devolvido." d="Shop.Theme.Terms"}</p>

  <p>{l s="A troca será efetuada seguindo o mesmo método de envio com o qual a compra foi primeiramente enviada." d="Shop.Theme.Terms"}</p>

</li>

</ol>
</div>
</div>
      {else}
      {$cms.content nofilter}
      {/if}
    {/block}

    {block name='hook_cms_dispute_information'}
      {hook h='displayCMSDisputeInformation'}
    {/block}

    {block name='hook_cms_print_button'}
      {hook h='displayCMSPrintButton'}
    {/block}

  </section>
{/block}

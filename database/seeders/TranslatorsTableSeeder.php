<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslatorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('translators')->delete();
        
        \DB::table('translators')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'are_you_seeking_new_and_rewarding_job_opportunities_that_allow_you_to_make_a_meaningful_impact_on_the_lives_of_elderly_individuals_and_those_with_specific_needs?_look_no_further_than_our_communication_and_services_platform,_exclusively_designed_for_professionals_like_you._set_you_own_schedule,_hours_and_salary._your_in_charge',
                'en' => 'Are You Seeking New And Rewarding Job Opportunities That Allow You To Make A Meaningful Impact On The Lives Of Elderly Individuals And Those With Specific Needs? Look No Further Than Our Communication And Services Platform, Exclusively Designed For Professionals Like You. Set You Own Schedule, Hours And Salary. Your In Charge',
                'es' => '¿Está buscando oportunidades de trabajo nuevas y gratificantes que le permitan tener un impacto significativo en las vidas de las personas mayores y las personas con necesidades específicas? No busque más allá de nuestra plataforma de comunicación y servicios, diseñada exclusivamente para profesionales como usted. Establezca su propio horario, horas y salario. Tu Encargo',
                'created_at' => '2023-08-05 09:25:15',
                'updated_at' => '2023-08-05 09:25:15',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'with_just_a_few_clicks,_you_can_narrow_your_search,_access_detailed_information,_and_compare_different_nursing_homes_side_by_side._our_innovative_filtering_system_allows_you_to_customize_your_search_based_on_crucial_factors_like_price,_location,_services_provided,_facility_ratings,_and_patient_reviews._by_taking_advantage_of_this_tool,_you_can_confidently_navigate_the_complex_world_of_nursing_home_selection,_saving_you_precious_time_and_ensuring_peace_of_mind.',
                'en' => 'With Just A Few Clicks, You Can Narrow Your Search, Access Detailed Information, And Compare Different Nursing Homes Side By Side. Our Innovative Filtering System Allows You To Customize Your Search Based On Crucial Factors Like Price, Location, Services Provided, Facility Ratings, And Patient Reviews. By Taking Advantage Of This Tool, You Can Confidently Navigate The Complex World Of Nursing Home Selection, Saving You Precious Time And Ensuring Peace Of Mind.',
                'es' => 'Con solo unos pocos clics, puede limitar su búsqueda, acceder a información detallada y comparar diferentes hogares de ancianos uno al lado del otro. Nuestro innovador sistema de filtrado le permite personalizar su búsqueda en función de factores cruciales como el precio, la ubicación, los servicios prestados, las calificaciones de las instalaciones y las revisiones de los pacientes. Al aprovechar esta herramienta, puede navegar con confianza por el complejo mundo de la selección de hogares de ancianos, ahorrándole un tiempo precioso y asegurando su tranquilidad.',
                'created_at' => '2023-08-05 09:32:55',
                'updated_at' => '2023-08-05 09:32:55',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Welcome2',
                'en' => 'Welcome2',
                'es' => 'bienvenida2',
                'created_at' => '2023-08-05 09:36:50',
                'updated_at' => '2023-08-05 11:53:09',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'at_avanzando_juntos_corporation,_we_believe_that_finding_the_right_care_is_a_journey_of_compassion,_understanding,_and_trust._we_understand_the_significance_of_this_process,_and_we_are_here_to_guide_you_every_step_of_the_way.',
                'en' => 'At Avanzando Juntos Corporation, We Believe That Finding The Right Care Is A Journey Of Compassion, Understanding, And Trust. We Understand The Significance Of This Process, And We Are Here To Guide You Every Step Of The Way.',
                'es' => 'En Avanzando Juntos Corporation, creemos que encontrar la atención adecuada es un viaje de compasión, comprensión y confianza. Entendemos la importancia de este proceso, y estamos aquí para guiarlo en cada paso del camino.',
                'created_at' => '2023-08-05 09:37:38',
                'updated_at' => '2023-08-05 09:37:38',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'our_mission_is_rooted_in_the_belief_that_exceptional_care_should_be_accessible_to_all,_and_that\'s_why_we_have_created_a_platform_dedicated_to_facilitating_the_search_for_care._whether_you_are_seeking_care_for_yourself_or_a_loved_one,_we_know_that_the_decision-making_process_can_be_both_emotionally_and_logistically_challenging._that\'s_where_we_come_in.',
                'en' => 'Our Mission Is Rooted In The Belief That Exceptional Care Should Be Accessible To All, And That\'s Why We Have Created A Platform Dedicated To Facilitating The Search For Care. Whether You Are Seeking Care For Yourself Or A Loved One, We Know That The Decision-Making Process Can Be Both Emotionally And Logistically Challenging. That\'s Where We Come In.',
                'es' => 'Nuestra misión se basa en la creencia de que la atención excepcional debe ser accesible para todos, y es por eso que hemos creado una plataforma dedicada a facilitar la búsqueda de atención. Ya sea que esté buscando atención para usted o un ser querido, sabemos que el proceso de toma de decisiones puede ser emocional y logísticamente desafiante. Ahí es donde entramos nosotros.',
                'created_at' => '2023-08-05 09:42:00',
                'updated_at' => '2023-08-05 09:42:00',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'finding_the_right_care_for_yourself_or_your_loved_ones_can_be_a_daunting_task._that\'s_why_our_website_is_here_to_simplify_and_revolutionize_the_process,_ensuring_that_you_find_personalized,_compassionate_care_that_meets_your_unique_needs_and_preferences.',
                'en' => 'Finding The Right Care For Yourself Or Your Loved Ones Can Be A Daunting Task. That\'s Why Our Website Is Here To Simplify And Revolutionize The Process, Ensuring That You Find Personalized, Compassionate Care That Meets Your Unique Needs And Preferences.',
                'es' => 'Encontrar la atención adecuada para usted o sus seres queridos puede ser una tarea desalentadora. Es por eso que nuestro sitio web está aquí para simplificar y revolucionar el proceso, asegurando que encuentre una atención personalizada y compasiva que satisfaga sus necesidades y preferencias únicas.',
                'created_at' => '2023-08-05 09:45:22',
                'updated_at' => '2023-08-05 09:45:22',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'nursing_home_search_engine',
                'en' => 'Nursing Home Search Engine',
                'es' => 'Motor de búsqueda de hogares de ancianos',
                'created_at' => '2023-08-05 09:55:45',
                'updated_at' => '2023-08-05 09:55:45',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'this_free_and_easy_to_use_tool_will_help_you_search_for_nursing_homes_near_you._facilitating_your_search_and_letting_you_connect_directly_with_the_home.',
                'en' => 'This FREE And Easy To Use Tool Will Help You Search For Nursing Homes Near You. Facilitating Your Search And Letting You Connect Directly With The Home.',
                'es' => 'Esta herramienta GRATUITA y fácil de usar lo ayudará a buscar hogares de ancianos cerca de usted. Facilitando su búsqueda y permitiéndole conectarse directamente con el hogar.',
                'created_at' => '2023-08-05 09:59:06',
                'updated_at' => '2023-08-05 09:59:06',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'why_choose_avanzando_juntos',
                'en' => 'Why Choose Avanzando Juntos',
                'es' => 'Por qué elegir Avanzando Juntos',
                'created_at' => '2023-08-05 10:01:10',
                'updated_at' => '2023-08-05 10:01:10',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'affordable_and_accessible',
                'en' => 'Affordable And Accessible',
                'es' => 'Asequible y accesible',
                'created_at' => '2023-08-05 10:04:14',
                'updated_at' => '2023-08-05 10:04:14',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'while_certain_tools_are_free,_we_have_many_other_features_that_can_further_assist_you_in_many_areas_for_a_low_price._register_for_employment_as_a_caregiver,_see_avaliabilities_of_beds_in_nursing_homes,_create_profiles_and_contact_providers_directly.',
                'en' => 'While Certain Tools Are Free, We Have Many Other Features That Can Further Assist You In Many Areas For A Low Price. Register For Employment As A Caregiver, See Avaliabilities Of Beds In Nursing Homes, Create Profiles And Contact Providers Directly.',
                'es' => 'Si bien ciertas herramientas son gratuitas, tenemos muchas otras características que pueden ayudarlo en muchas áreas por un precio bajo. Regístrese para el empleo como cuidador, vea la disponibilidad de camas en hogares de ancianos, cree perfiles y contacte directamente a los proveedores.',
                'created_at' => '2023-08-05 10:07:49',
                'updated_at' => '2023-08-05 10:07:49',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'easy_to_use_technology',
                'en' => 'Easy To Use Technology',
                'es' => 'Tecnología fácil de usar',
                'created_at' => '2023-08-05 10:10:05',
                'updated_at' => '2023-08-05 10:10:05',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'our_tech_team_has_created_this_website_with_you_in_mind._you_can_contact_us_directly_for_any_questions._we_want_to_facilitate_an_already_difficult_task_by_helping_you_search_for_care_and_make_informed_decisions_.',
                'en' => 'Our Tech Team Has Created This Website With You In Mind. You Can Contact Us Directly For Any Questions. We Want To Facilitate An Already Difficult Task By Helping You Search For Care And Make Informed Decisions .',
                'es' => 'Nuestro equipo técnico ha creado este sitio web pensando en usted. Puede contactarnos directamente para cualquier pregunta. Queremos facilitar una tarea que ya es difícil ayudándolo a buscar atención y tomar decisiones informadas.',
                'created_at' => '2023-08-05 10:12:04',
                'updated_at' => '2023-08-05 10:12:04',
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'caregiver_search',
                'en' => 'Caregiver Search',
                'es' => 'Búsqueda de cuidador',
                'created_at' => '2023-08-05 10:13:50',
                'updated_at' => '2023-08-05 10:13:50',
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'register_your_nursing_home_with_us_today',
                'en' => 'REGISTER YOUR NURSING HOME WITH US TODAY',
                'es' => 'REGISTRE SU HOGAR DE ANCIANOS CON NOSOTROS HOY',
                'created_at' => '2023-08-05 10:48:41',
                'updated_at' => '2023-08-05 10:48:41',
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'nursing_homes_provided_in_search_are_ones_registered_with_the_state.',
                'en' => 'Nursing homes provided in search are ones registered with the state.',
                'es' => 'Los hogares de ancianos proporcionados en la búsqueda son los registrados en el estado.',
                'created_at' => '2023-08-05 10:48:41',
                'updated_at' => '2023-08-05 10:48:41',
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'advancing_together_was_born_out_of_the_need_that_i_observed_in_the_homes_for_the_elderly_where_i_was_employed._i_saw_firsthand_how_families_were_overwhelmed_by_having_to_find_a_home_or_professional_service_for_their_loved_one._this_process_is_already_difficult_in_itself,_and_without_a_proper_and_organized_system_with_all_the_necessary_information_available_in_one_place,_it_becomes_an_exhausting,_complicated_and_expensive_process._from_the_effort_and_desperation_of_relatives,_avanzando_juntos_was_born,_a_web_page_designed_to_gather_information_already_available_to_be_able_to_locate_and_understand_this_process_along_with_their_rights_as_relatives_and_patients.',
                'en' => 'Advancing Together Was Born Out Of The Need That I Observed In The Homes For The Elderly Where I Was Employed. I Saw Firsthand How Families Were Overwhelmed By Having To Find A Home Or Professional Service For Their Loved One. This Process Is Already Difficult In Itself, And Without A Proper And Organized System With All The Necessary Information Available In One Place, It Becomes An Exhausting, Complicated And Expensive Process. From The Effort And Desperation Of Relatives, Avanzando Juntos Was Born, A Web Page Designed To Gather Information Already Available To Be Able To Locate And Understand This Process Along With Their Rights As Relatives And Patients.',
                'es' => 'Avanzando juntos nació de la necesidad que observé en los hogares para ancianos donde trabajaba. Vi de primera mano cómo las familias se sintieron abrumadas por tener que encontrar un hogar o un servicio profesional para su ser querido. Este proceso ya es difícil en sí mismo, y sin un sistema adecuado y organizado con toda la información necesaria disponible en un solo lugar, se convierte en un proceso agotador, complicado y costoso. Del esfuerzo y la desesperación de los familiares, Nace Avanzando Juntos, una página web diseñada para recopilar información ya disponible para poder localizar y comprender este proceso junto con sus derechos como familiares y pacientes.',
                'created_at' => '2023-08-05 10:48:41',
                'updated_at' => '2023-08-05 10:48:41',
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'our_services',
                'en' => 'OUR SERVICES',
                'es' => 'NUESTROS SERVICIOS',
                'created_at' => '2023-08-05 10:48:41',
                'updated_at' => '2023-08-05 10:48:41',
            ),
            18 => 
            array (
                'id' => 20,
                'title' => 'avanzando_juntos_corporation_does_not_employ_or_recommend_any_care_provider._avanzando_juntos_corporation_provides_technology_and_tools_to_help_families_and_caregivers_connect_with_each_other._each_individual_is_solely_responsible_for_selecting_a_care_provider_or_care_seeker,_whichever_applies,_and_complying_with_local_and_federal_laws_in_connection_with_a_business_relationship_they_create.',
                'en' => 'Avanzando Juntos Corporation does not employ or recommend any care provider. Avanzando Juntos Corporation provides technology and tools to help families and Caregivers connect with each other. Each individual is solely responsible for selecting a care provider or care seeker, whichever applies, and complying with local and federal laws in connection with a business relationship they create.',
                'es' => 'Avanzando Juntos Corporation no emplea ni recomienda a ningún proveedor de atención. Avanzando Juntos Corporation proporciona tecnología y herramientas para ayudar a las familias y los cuidadores a conectarse entre sí. Cada individuo es el único responsable de seleccionar un proveedor de atención o un solicitante de atención, según corresponda, y de cumplir con las leyes locales y federales en relación con una relación comercial que creen.',
                'created_at' => '2023-08-05 10:56:48',
                'updated_at' => '2023-08-05 10:56:48',
            ),
            19 => 
            array (
                'id' => 21,
                'title' => 'search_nursing_homes',
                'en' => 'Search Nursing Homes',
                'es' => 'Buscar Hogares de Ancianos',
                'created_at' => '2023-08-05 11:11:39',
                'updated_at' => '2023-08-05 11:11:39',
            ),
            20 => 
            array (
                'id' => 23,
                'title' => 'best_carehomes',
                'en' => 'Best Carehomes',
                'es' => 'Los mejores hogares de cuidado',
                'created_at' => '2023-08-05 11:13:04',
                'updated_at' => '2023-08-05 11:13:04',
            ),
            21 => 
            array (
                'id' => 24,
                'title' => 'for_your_health',
                'en' => 'For Your Health',
                'es' => 'Para su salud',
                'created_at' => '2023-08-05 11:13:04',
                'updated_at' => '2023-08-05 11:13:04',
            ),
            22 => 
            array (
                'id' => 25,
                'title' => 'for_free',
                'en' => 'For Free',
                'es' => 'Gratuitamente',
                'created_at' => '2023-08-05 11:13:31',
                'updated_at' => '2023-08-05 11:13:31',
            ),
            23 => 
            array (
                'id' => 26,
                'title' => 'no_data_found',
                'en' => 'No data found',
                'es' => 'No se han encontrado datos',
                'created_at' => '2023-08-05 11:19:06',
                'updated_at' => '2023-08-05 11:19:06',
            ),
            24 => 
            array (
                'id' => 27,
                'title' => 'featured_your_care_homes',
                'en' => 'Featured Your Care Homes',
                'es' => 'Destacados sus hogares de cuidado',
                'created_at' => '2023-08-05 11:20:33',
                'updated_at' => '2023-08-05 11:20:33',
            ),
            25 => 
            array (
                'id' => 28,
                'title' => 'the_mission_of_avanzando_juntos_corporation_is_to_facilitate_to_process_of_finding_care_for_the_public_and_to_bridge_the_gap_between_healthcare_providers_and_the_families_of_patients_by_creating_awareness_to_the_importance_of_provide_transparent_and_dignified_care.',
                'en' => 'The Mission Of Avanzando Juntos Corporation Is To Facilitate To Process Of Finding Care For The Public And To Bridge The Gap Between Healthcare Providers And The Families Of Patients By Creating Awareness To The Importance Of Provide Transparent And Dignified Care.',
                'es' => 'La misión de la Corporación Avanzando Juntos es facilitar el proceso de búsqueda de atención para el público y cerrar la brecha entre los proveedores de atención médica y las familias de los pacientes creando conciencia sobre la importancia de brindar una atención transparente y digna.',
                'created_at' => '2023-08-05 11:22:54',
                'updated_at' => '2023-08-05 11:22:54',
            ),
            26 => 
            array (
                'id' => 29,
                'title' => 'resources',
                'en' => 'Resources',
                'es' => 'Recursos',
                'created_at' => '2023-08-05 11:24:00',
                'updated_at' => '2023-08-05 11:24:00',
            ),
            27 => 
            array (
                'id' => 32,
                'title' => 'we_prodive_a_dedicated_support_24/7_for_any_your_question',
                'en' => 'We prodive a dedicated support 24/7 for any your question',
                'es' => 'Prodive un soporte dedicado 24/7 para cualquier pregunta',
                'created_at' => '2023-08-05 11:29:08',
                'updated_at' => '2023-08-05 11:29:08',
            ),
            28 => 
            array (
                'id' => 34,
                'title' => 'our_mission',
                'en' => 'Our Mission',
                'es' => 'Nuestra misión',
                'created_at' => '2023-08-05 11:50:54',
                'updated_at' => '2023-08-05 11:50:54',
            ),
            29 => 
            array (
                'id' => 36,
                'title' => 'book_an_',
                'en' => 'Book An',
                'es' => 'Reservar An',
                'created_at' => '2023-08-05 11:59:09',
                'updated_at' => '2023-08-05 11:59:09',
            ),
            30 => 
            array (
                'id' => 37,
                'title' => 'appointment',
                'en' => 'Appointment',
                'es' => 'cita',
                'created_at' => '2023-08-05 12:00:10',
                'updated_at' => '2023-08-05 12:00:10',
            ),
            31 => 
            array (
                'id' => 38,
                'title' => 'reservation',
                'en' => 'Reservation',
                'es' => 'reserva',
                'created_at' => '2023-08-05 12:02:13',
                'updated_at' => '2023-08-05 12:02:13',
            ),
            32 => 
            array (
                'id' => 40,
                'title' => 'the_vision_of_avanzando_juntos_corporation_is_to_become_the_#1_source_of_excelente_and_transparent_care_providers._we_strive_to_motivate_advancement_in_the_advocacy_of_care_and_sparks_major_changes_to_expect_the_highest_holistic_care_for_all.',
                'en' => 'The vision of Avanzando Juntos Corporation is to become the #1 source of excelente and transparent care providers. We strive to motivate advancement in the advocacy of care and sparks major changes to expect the highest holistic care for all.',
                'es' => 'La visión de Corporación Avanzando Juntos es convertirse en la fuente #1 de proveedores de atención excelentes y transparentes. Nos esforzamos por motivar el avance en la defensa de la atención y generar cambios importantes para esperar la atención holística más alta para todos.',
                'created_at' => '2023-08-05 12:20:57',
                'updated_at' => '2023-08-05 12:20:57',
            ),
            33 => 
            array (
                'id' => 41,
                'title' => 'transparency_–_we_believe_every_patient_deserves_the_highest_quality_care_possible_especially_at_their_most_vulnerable_state._we_want_to_provide_as_much_information_as_possible_to_help_families_make_the_best_decisions.',
                'en' => 'Transparency – We believe every patient deserves the highest quality care possible especially at their most vulnerable state. We want to provide as much information as possible to help families make the best decisions.',
                'es' => 'Transparencia: creemos que todos los pacientes merecen la atención de la más alta calidad posible, especialmente en su estado más vulnerable. Queremos brindar la mayor cantidad de información posible para ayudar a las familias a tomar las mejores decisiones.',
                'created_at' => '2023-08-05 12:23:49',
                'updated_at' => '2023-08-05 12:23:49',
            ),
            34 => 
            array (
                'id' => 42,
                'title' => 'independence_and_impartiality_–_we_work_constantly_on_earning_your_trust_by_providing_updated_information_and_organizing_it_accordingly_so_that_you_have_access_to_everything,_all_in_one_place._facts_without_prejudice_or_improper_influence_will_always_come_first.',
                'en' => 'Independence and impartiality – We work constantly on earning your trust by providing updated information and organizing it accordingly so that you have access to everything, all in one place. Facts without prejudice or improper influence will always come first.',
                'es' => 'Independencia e imparcialidad: trabajamos constantemente para ganarnos su confianza al proporcionar información actualizada y organizarla en consecuencia para que tenga acceso a todo, todo en un solo lugar. Los hechos sin prejuicios o influencias indebidas siempre tendrán prioridad.',
                'created_at' => '2023-08-05 12:26:17',
                'updated_at' => '2023-08-05 12:26:17',
            ),
            35 => 
            array (
                'id' => 43,
                'title' => 'respect_–_respect_is_valued_in_every_difference_regardless_of_age,_race,_or_nationality._everyone_deserves_to_be_treated_with_compassion,_dignity_and_fairness.',
                'en' => 'Respect – Respect is valued in every difference regardless of age, race, or nationality. Everyone deserves to be treated with compassion, dignity and fairness.',
                'es' => 'Respeto: el respeto se valora en todas las diferencias, independientemente de la edad, la raza o la nacionalidad. Todos merecen ser tratados con compasión, dignidad y justicia.',
                'created_at' => '2023-08-05 12:28:03',
                'updated_at' => '2023-08-05 12:28:03',
            ),
            36 => 
            array (
                'id' => 44,
                'title' => 'defiition_according_to_the_law_of_establishments_for_advanced_persons:_law_no._94_of_june_22,_1977,_p._94,_as_amended_(disclaimer:_we_have_not_added_complete_definition,_just_small_summary_of_each._to_read_full_definition,_please_click_on_link_found_below._eclac',
                    'en' => 'DEFIITION ACCORDING TO THE LAW OF ESTABLISHMENTS FOR ADVANCED PERSONS: Law No. 94 of June 22, 1977, p. 94, as amended (Disclaimer: we have not added complete definition, just small summary of each. To read full definition, please click on link found below. ECLAC',
                        'es' => 'DEFINICIÓN SEGÚN LA LEY DE ESTABLECIMIENTOS PARA PERSONAS AVANZADAS: Ley N° 94 de 22 de junio de 1977, pág. 94, modificada (Aviso: no hemos agregado la definición completa, solo un pequeño resumen de cada una. Para leer la definición completa, haga clic en el enlace que se encuentra a continuación. CEPAL',
                            'created_at' => '2023-08-05 12:30:46',
                            'updated_at' => '2023-08-05 12:30:46',
                        ),
                        37 => 
                        array (
                            'id' => 45,
                        'title' => 'institution:_any_type_of_home,_as_described_by_this_law,_that_provides_24_hour_care_and_has_more_than_7_patients._(click_on_link_to_read_entirety_of_information)',
                        'en' => 'Institution: Any type of home, as described by this law, that provides 24 hour care and has more than 7 patients. (Click on link to read entirety of information)',
                        'es' => 'Institución: Cualquier tipo de hogar, según lo descrito por esta ley, que brinda atención las 24 horas y tiene más de 7 pacientes. (Haga clic en el enlace para leer la información completa)',
                            'created_at' => '2023-08-05 12:33:27',
                            'updated_at' => '2023-08-05 12:33:27',
                        ),
                        38 => 
                        array (
                            'id' => 47,
                            'title' => 'law_no._94_of_june_22,_1977,_p._94,_as_amended_(disclaimer:_we_have_not_added_complete_definition,_just_small_summary_of_each._to_read_full_definition,_please_click_on_link_found_below._eclac',
                                'en' => 'Law No. 94 of June 22, 1977, p. 94, as amended (Disclaimer: we have not added complete definition, just small summary of each. To read full definition, please click on link found below. ECLAC',
                                    'es' => 'Ley Núm. 94 de 22 de junio de 1977, pág. 94, modificada (Aviso: no hemos agregado la definición completa, solo un pequeño resumen de cada una. Para leer la definición completa, haga clic en el enlace que se encuentra a continuación. CEPAL',
                                        'created_at' => '2023-08-05 12:39:07',
                                        'updated_at' => '2023-08-05 12:39:07',
                                    ),
                                    39 => 
                                    array (
                                        'id' => 49,
                                        'title' => 'home_of_a_family_that_pays_for_care_during_the_day_for_a_maximum_of_6_adults,_not_related_by_said_family_by_blood.',
                                        'en' => 'Home of a family that pays for care during the day for a maximum of 6 adults, not related by said family by blood.',
                                        'es' => 'Hogar de una familia que paga el cuidado durante el día de un máximo de 6 adultos, no emparentados por dicha familia por consanguinidad.',
                                        'created_at' => '2023-08-05 12:43:26',
                                        'updated_at' => '2023-08-05 12:43:26',
                                    ),
                                    40 => 
                                    array (
                                        'id' => 50,
                                        'title' => 'home_of_family_dedicated_to_the_care_of_no_more_than_6_elderly_people,_coming_from_other_homes,_or_families,_24_hrs_a_day,_with_or_without_pecuniary_purposes.',
                                        'en' => 'Home of family dedicated to the care of no more than 6 elderly people, coming from other homes, or families, 24 hrs a day, with or without pecuniary purposes.',
                                        'es' => 'Hogar de familia dedicado al cuidado de no más de 6 personas mayores, provenientes de otros hogares, o familias, las 24 horas del día, con o sin fines pecuniarios.',
                                        'created_at' => '2023-08-05 12:45:06',
                                        'updated_at' => '2023-08-05 12:45:06',
                                    ),
                                    41 => 
                                    array (
                                        'id' => 51,
                                        'title' => 'best_professionals_for_your_heatlh',
                                        'en' => 'BEST PROFESSIONALS FOR YOUR HEATLH',
                                        'es' => 'LOS MEJORES PROFESIONALES PARA TU SALUD',
                                        'created_at' => '2023-08-05 12:46:44',
                                        'updated_at' => '2023-08-05 12:46:44',
                                    ),
                                    42 => 
                                    array (
                                        'id' => 52,
                                        'title' => 'an_establishment,_with_or_without_pecuniary_purposes,_where_a_variety_of_servicies_are_provided_to_the_elderly,_mostly_health_services_to_people_with_more_than_three_daily_living_limitations.',
                                        'en' => 'an establishment, with or without pecuniary purposes, where a variety of servicies are provided to the elderly, mostly health services to people with more than three daily living limitations.',
                                        'es' => 'un establecimiento, con o sin fines pecuniarios, donde se prestan una variedad de servicios a las personas mayores, en su mayoría servicios de salud a personas con más de tres limitaciones en la vida diaria.',
                                        'created_at' => '2023-08-05 12:47:49',
                                        'updated_at' => '2023-08-05 12:47:49',
                                    ),
                                    43 => 
                                    array (
                                        'id' => 53,
                                        'title' => 'services',
                                        'en' => 'Services',
                                        'es' => 'Servicios',
                                        'created_at' => '2023-08-05 12:49:25',
                                        'updated_at' => '2023-08-05 12:49:25',
                                    ),
                                    44 => 
                                    array (
                                        'id' => 54,
                                        'title' => 'that_we_provide',
                                        'en' => 'That We Provide',
                                        'es' => 'que proporcionamos',
                                        'created_at' => '2023-08-05 12:58:42',
                                        'updated_at' => '2023-08-05 12:58:42',
                                    ),
                                    45 => 
                                    array (
                                        'id' => 55,
                                        'title' => 'search_best_professionals',
                                        'en' => 'Search Best Professionals',
                                        'es' => 'Buscar Mejores Profesionales',
                                        'created_at' => '2023-08-05 13:02:55',
                                        'updated_at' => '2023-08-05 13:02:55',
                                    ),
                                    46 => 
                                    array (
                                        'id' => 56,
                                        'title' => 'defiition_according_to_the_law_of_establishments_for_advanced_persons',
                                        'en' => 'DEFIITION ACCORDING TO THE LAW OF ESTABLISHMENTS FOR ADVANCED PERSONS',
                                        'es' => 'DEFINICIÓN SEGÚN LA LEY DE ESTABLECIMIENTOS PARA PERSONAS AVANZADAS',
                                        'created_at' => '2023-08-05 13:09:01',
                                        'updated_at' => '2023-08-05 13:09:01',
                                    ),
                                    47 => 
                                    array (
                                        'id' => 57,
                                        'title' => 'institution',
                                        'en' => 'Institution',
                                        'es' => 'Institución',
                                        'created_at' => '2023-08-05 13:10:35',
                                        'updated_at' => '2023-08-05 13:10:35',
                                    ),
                                    48 => 
                                    array (
                                        'id' => 58,
                                        'title' => 'for_your_health',
                                        'en' => 'For Your Health',
                                        'es' => 'Para su salud',
                                        'created_at' => '2023-08-05 13:12:17',
                                        'updated_at' => '2023-08-05 13:12:17',
                                    ),
                                    49 => 
                                    array (
                                        'id' => 59,
                                    'title' => '_any_type_of_home,_as_described_by_this_law,_that_provides_24_hour_care_and_has_more_than_7_patients._(click_on_link_to_read_entirety_of_information)',
                                    'en' => 'Any type of home, as described by this law, that provides 24 hour care and has more than 7 patients. (Click on link to read entirety of information)',
                                    'es' => 'Cualquier tipo de hogar, según lo descrito por esta ley, que brinda atención las 24 horas y tiene más de 7 pacientes. (Haga clic en el enlace para leer la información completa)',
                                        'created_at' => '2023-08-05 13:12:37',
                                        'updated_at' => '2023-08-05 13:12:37',
                                    ),
                                    50 => 
                                    array (
                                        'id' => 60,
                                        'title' => 'best_professional',
                                        'en' => 'Best Professional',
                                        'es' => 'Mejor Profesional',
                                        'created_at' => '2023-08-05 13:13:35',
                                        'updated_at' => '2023-08-05 13:13:35',
                                    ),
                                    51 => 
                                    array (
                                        'id' => 61,
                                        'title' => '_an_establishment,_with_or_without_pecuniary_purposes,_where_a_variety_of_servicies_are_provided_to_the_elderly,_mostly_health_services_to_people_with_more_than_three_daily_living_limitations.',
                                        'en' => 'an establishment, with or without pecuniary purposes, where a variety of servicies are provided to the elderly, mostly health services to people with more than three daily living limitations.',
                                        'es' => 'un establecimiento, con o sin fines pecuniarios, donde se prestan una variedad de servicios a las personas mayores, en su mayoría servicios de salud a personas con más de tres limitaciones en la vida diaria.',
                                        'created_at' => '2023-08-05 13:16:43',
                                        'updated_at' => '2023-08-05 13:16:43',
                                    ),
                                    52 => 
                                    array (
                                        'id' => 62,
                                        'title' => 'an_establishment,_with_or_without_pecuniary_purposes,_where_a_series_of_services_are_provided_to_the_elderly,_mostly_social,_recreational,_with_the_purpose_of_maintaining_or_maximizing_their_independence_during_part_of_the_24_hours_of_the_day.',
                                        'en' => 'an establishment, with or without pecuniary purposes, where a series of services are provided to the elderly, mostly social, recreational, with the purpose of maintaining or maximizing their independence during part of the 24 hours of the day.',
                                        'es' => 'un establecimiento, con o sin fines pecuniarios, donde se prestan una serie de servicios a las personas mayores, en su mayoría sociales, recreativas, con el propósito de mantener o maximizar su independencia durante parte de las 24 horas del día.',
                                        'created_at' => '2023-08-05 13:20:59',
                                        'updated_at' => '2023-08-05 13:20:59',
                                    ),
                                    53 => 
                                    array (
                                        'id' => 63,
                                        'title' => 'featured_your_professional',
                                        'en' => 'Featured Your Professional',
                                        'es' => 'Destacada tu profesional',
                                        'created_at' => '2023-08-05 13:23:10',
                                        'updated_at' => '2023-08-05 13:23:10',
                                    ),
                                    54 => 
                                    array (
                                        'id' => 64,
                                        'title' => 'day_care_home:',
                                        'en' => 'Day care home:',
                                        'es' => 'Hogar de día:',
                                        'created_at' => '2023-08-05 13:24:07',
                                        'updated_at' => '2023-08-05 13:24:07',
                                    ),
                                    55 => 
                                    array (
                                        'id' => 65,
                                        'title' => 'latest_from',
                                        'en' => 'Latest From',
                                        'es' => 'Lo último de',
                                        'created_at' => '2023-08-05 13:24:50',
                                        'updated_at' => '2023-08-05 13:24:50',
                                    ),
                                    56 => 
                                    array (
                                        'id' => 66,
                                        'title' => 'our_blog',
                                        'en' => 'Our Blog',
                                        'es' => 'Nuestro Blog',
                                        'created_at' => '2023-08-05 13:25:38',
                                        'updated_at' => '2023-08-05 13:25:38',
                                    ),
                                    57 => 
                                    array (
                                        'id' => 67,
                                        'title' => 'day_care_home',
                                        'en' => 'Day care home',
                                        'es' => 'casa de cuidado diurno',
                                        'created_at' => '2023-08-05 13:25:57',
                                        'updated_at' => '2023-08-05 13:25:57',
                                    ),
                                    58 => 
                                    array (
                                        'id' => 68,
                                        'title' => 'foster_home',
                                        'en' => 'Foster home',
                                        'es' => 'casa de acogida',
                                        'created_at' => '2023-08-05 13:27:23',
                                        'updated_at' => '2023-08-05 13:27:23',
                                    ),
                                    59 => 
                                    array (
                                        'id' => 69,
                                        'title' => 'day_care_center',
                                        'en' => 'Day Care Center',
                                        'es' => 'Centro de cuidado diurno',
                                        'created_at' => '2023-08-05 13:28:42',
                                        'updated_at' => '2023-08-05 13:28:42',
                                    ),
                                    60 => 
                                    array (
                                        'id' => 70,
                                        'title' => 'multiple_activity_center',
                                        'en' => 'Multiple Activity Center',
                                        'es' => 'Centro de actividades múltiples',
                                        'created_at' => '2023-08-05 13:29:50',
                                        'updated_at' => '2023-08-05 13:29:50',
                                    ),
                                    61 => 
                                    array (
                                        'id' => 71,
                                        'title' => 'day_care_center',
                                        'en' => 'Day Care Center',
                                        'es' => 'Centro de cuidado diurno',
                                        'created_at' => '2023-08-05 13:31:57',
                                        'updated_at' => '2023-08-05 13:31:57',
                                    ),
                                    62 => 
                                    array (
                                        'id' => 73,
                                        'title' => 'organization',
                                        'en' => 'Organization',
                                        'es' => 'Organización',
                                        'created_at' => '2023-08-05 13:33:56',
                                        'updated_at' => '2023-08-05 13:33:56',
                                    ),
                                    63 => 
                                    array (
                                        'id' => 74,
                                        'title' => 'vision',
                                        'en' => 'Vision',
                                        'es' => 'Visión',
                                        'created_at' => '2023-08-05 13:35:09',
                                        'updated_at' => '2023-08-05 13:35:09',
                                    ),
                                    64 => 
                                    array (
                                        'id' => 75,
                                        'title' => 'our_values',
                                        'en' => 'Our Values',
                                        'es' => 'Nuestras Valores',
                                        'created_at' => '2023-08-05 13:35:54',
                                        'updated_at' => '2023-08-05 13:35:54',
                                    ),
                                    65 => 
                                    array (
                                        'id' => 76,
                                        'title' => 'our_platform_is_supervised_by_our_ceo,_rachel_m._gaona,_a_registered_nurse_with_many_years_of_experience_in_providing_excelente_care._our_team_adheres_to_the_highest_standards_of_ethical_behavior._we_understand_that_we_must_work_to_earn_the_public’s_trust._we_work_every_day_to_provide_the_highest_level_of_service.',
                                        'en' => 'Our platform is supervised by our CEO, Rachel M. Gaona, a registered nurse with many years of experience in providing excelente care. Our team adheres to the highest standards of ethical behavior. We understand that WE must work to earn the public’s trust. We work every day to provide the highest level of service.',
                                        'es' => 'Nuestra plataforma está supervisada por nuestra directora ejecutiva, Rachel M. Gaona, una enfermera registrada con muchos años de experiencia brindando una atención excelente. Nuestro equipo se adhiere a los más altos estándares de comportamiento ético. Entendemos que NOSOTROS debemos trabajar para ganarnos la confianza del público. Trabajamos todos los días para brindar el más alto nivel de servicio.',
                                        'created_at' => '2023-08-05 13:39:26',
                                        'updated_at' => '2023-08-05 13:39:26',
                                    ),
                                    66 => 
                                    array (
                                        'id' => 77,
                                        'title' => 'links_of_public_information_related_to_platform',
                                        'en' => 'Links Of Public Information Related To Platform',
                                        'es' => 'Enlaces de información pública relacionada con la plataforma',
                                        'created_at' => '2023-08-05 13:42:13',
                                        'updated_at' => '2023-08-05 13:42:13',
                                    ),
                                    67 => 
                                    array (
                                        'id' => 78,
                                        'title' => 'oppea',
                                        'en' => 'OPPEA',
                                        'es' => 'OPPEA',
                                        'created_at' => '2023-08-05 13:44:48',
                                        'updated_at' => '2023-08-05 13:44:48',
                                    ),
                                ));
        
        
    }
}
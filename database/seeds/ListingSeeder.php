<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                "title" => "Staten Island Urby 8 Navy Pier Ct, Staten Island, NY 10304 ",
                "description" => "
                At the heart of Staten Island’s new North Shore waterfront, Urby is a total rethink for a new generation of apartment seekers. Our brand new studio, one- and two-bedroom apartments are designed to make life easy. Each rental features built-in storage and custom closets, in-home washer/dryer and oversized windows for amazing light and views of NYC. Built for convenience, there is a cafe in the lobby to keep residents powered up, communal kitchen with chef-in-residence, and digital package pick-up. Friendly to any type of commute, Urby is located steps from the Stapleton Train Stop and has parking available to residents along with a bike room. Urby also has amenities that support a healthy lifestyle including an outdoor pool, 2-floor indoor Technogym(R) fitness center, filtered communal well, and easy access to a brand new waterfront esplanade.
                ",
                "image" => "http://schools.dev.com/images/umar_staerster_picture.JPG",
                "price" => "1850"
            ],
            [
                "title" => "The Drake 6260 99th St, Rego Park, NY 11374 ",
                "description" => "
                An incomparable blend of style and sophistication awaits you at The Drake, featuring 420 new, luxury no-fee Rego Park apartments for rent. The Drake combines exceptional taste, modern design, and classic, understated elegance. The Drake's no-fee Rego Park rentals raise the bar with distinctive interiors, deluxe amenities, and a nod to its Queens heritage. One-to four-bedroom residences are available, all with flexible layouts and outdoor space. This Queens luxury rental building reflects the spirit of the original Drake, which was once a lively neighborhood movie theater. The Drake elevates your comfort and convenience in every aspect of life, as residents will enjoy access to an impressive suite of amenities. The Drake has a doorman and a resident lounge, a state-of-the-art fitness and wellness center, bike storage, laundry facilities, a spa and grooming center for pets, and a colorful playroom. The Drake welcomes you to a thriving culturally rich neighborhood, Rego Park, in the heart of Queens. With restaurants, entertainment, and transit right at your fingertips. And for all the possibilities for work and play, the M and R trains mean Manhattan is always just a quick ride away from your no-fee Queens apartment at The Drake.
                ",
                "image" => "http://schools.dev.com/images/umar_staerster_picture.JPG",
                "price" => "2400"
            ],
              [
                  "title" => "EOS 100 W 31st St, New York, NY 10001 ",
                  "description" => "
                    EOS offers distinctive residences, curated amenities and personalized service needed to engage New York City life to the fullest — inside and out. Premier recreation and relaxation facilities for residents to enjoy include a pool, fitness center on the lower level as well as a game room and entertaining areas on the tower’s 47th floor with sweeping views of Manhattan. EOS offers 375 smoke-free rental residences consisting of studios, one, two and two bedroom + den layouts. Each apartment contains a washer/dryer, dishwasher, hardwood floors, kitchens and bathrooms with premium finishes and fixtures. Consistent with The Durst Organization’s ongoing commitment to sustainability, EOS offers residents a vision of sustainability that both respects the natural world and promotes your wellbeing. Centered around the four core elements— Water, Air, Earth and Energy— EOS gives back to the environment and provides a home where people can thrive. Sustainable features have been woven throughout the building and each residence as an integral part of its design, construction and management.Stepping out from inside EOS, some of the most desirable neighborhoods await. Electric NoMad, with its mix of restaurants, hotels and boutiques, is at your doorstep. Stroll to Midtown, Bryant Park, the Flatiron District, Chelsea and the Meatpacking District. EOS residents are also within a five block walk to the following transit lines: 1, 2, 3, 6, B, D, F, M, N, Q, R, A, C, E, PATH, Amtrak trains and various bus routes. EOS provides residents the best that New York City has to offer, both inside and out. Come discover a neighborhood that immediately feels like home.
                    ",
                  "image" => "http://schools.dev.com/images/umar_staerster_picture.JPG",
                  "price" => "3923"
              ],
              [
                  "title" => "Normandie Court 225 E 95th St, New York, NY 10128 ",
                  "description" => "
                Normandie Court is a four tower property that occupies the entire block between Second and Third Avenues with our driveway entrance on 95th Street. In addition to 24-hour concierge and doormen, valet and package rooms, there is a roof-top health club, expanding over 25,000 sf, with spectacular views. The health club includes a pool, exercise rooms, steam and sauna rooms, sun decks, a lounge and many other amenities. There is a separate children’s playroom on the lobby level. On-site attended parking is available with direct access to the building. The neighborhood is very popular with young professionals as well as families. The services and amenities of the neighborhood make this an extremely desirable location. Note: We no longer offer the Moderate Income Program. Prices are subject to change on a daily basis. Lease terms are subject to change based on availability.
                ",
                  "image" => "http://schools.dev.com/images/umar_staerster_picture.JPG",
                  "price" => "3605"
              ]
          ];

        foreach ($data as $arr) {

            DB::table('listings')->insert([
                'title' => $arr['title'],
                'description' => $arr['description'],
                'image' => $arr['image'],
                'price' => $arr['price']
            ]);
        }
    }
}

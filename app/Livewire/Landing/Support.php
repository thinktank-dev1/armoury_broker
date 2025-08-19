<?php

namespace App\Livewire\Landing;


use Livewire\Component;
use Livewire\Attributes\Layout;
use Faker\Factory as Faker;

use Auth;
use App\Models\Contact;

class Support extends Component
{
    public $data = [];
    public $name, $surname, $email, $contact_number, $message;

    public function mount(){
        $this->setFaq();
        if(!Auth::guest()){
            $this->name = Auth::user()->name;
            $this->surname = Auth::user()->surname;
            $this->email = Auth::user()->email;
            $this->contact_number = Auth::user()->mobile_number;
        }
    }

    public function sendContact(){
        $this->validate([
            'name' => 'required', 
            'surname' => 'required', 
            'email' => 'required', 
            'contact_number' => 'required', 
            'message' => 'required'
        ]);

        $cnt = new Contact();

        if(!Auth::guest()){
            $cnt->user_id = Auth::user()->id;
        }
        $cnt->name = $this->name; 
        $cnt->surname = $this->surname;
        $cnt->email = $this->email;
        $cnt->contact_number = $this->contact_number;
        $cnt->message = $this->message;
        $cnt->save();
        session()->flash('status', 'Contact successfully sent.');
    }

    #[Layout('components.layouts.landing')]
    public function render(){
        return view('livewire.landing.support');
    }

    public function setFaq(){
        $this->data = [
            "General Platform Questions" => [
                'What is Armoury Broker?' => "Armoury Broker is a multi-vendor marketplace designed specifically for South Africa's firearms and firearm related equipment community. We facilitate secure peer-to-peer transactions of weapons, peripherals, and related tactical equipment through our platform.",
                'How is Armoury Broker different from other platforms?' => 'Unlike fragmented, informal channels like Telegram and WhatsApp, Armoury Broker provides a unified marketplace with secure escrow payments, comprehensive buyer and seller protection, transparent transaction history, and integrated dispute resolution processes.',
                'Who can use Armoury Broker?' => 'Our platform is designed for registered firearm owners, reloaders, sports and recreational shooters, dealers, and accessories suppliers who live in South Africa. Every user can act as both a buyer and seller through dual-role accounts.',
                'What devices can I use to access Armoury Broker?' => 'Armoury Broker is available on desktop, tablet and mobile devices via your web browser. You can also easily add it as a shortcut on your screen.',
            ],
            "Account & Registration" => [
                "How do I create an account?" => "You can register using Google or Facebook or create an account with email and password. A store will be automatically created for you, and you can immediately start buying and selling.",
                "Can I create my own store?" => "Yes! Every user can create and customize their own store to list items for sale. You can personalize your store with a name, description, avatar and banner image.",
            ],
            "Buying & Selling" => [
                "How do I list an item for sale?" => "To create a listing for your store, you select the option to add a new item. After that, you can upload high-quality images and include a description and information on quantity, brand, condition, and pricing. Our platform supports comprehensive categorization of all major manufacturers.",
                "What do I do when The brand of my item is not available on the list?" => "You can list the item as “Other” and email the name of the brand you would like to have added to the list to support@armourybroker.com. Our team will consolidate the updates and include them in future releases.",
                "What happens when someone wants to buy my item?" => "When a buyer purchases your item, you'll receive an automated notification that the item has been sold, pending payment confirmation. No manual confirmation is required from you at this stage.",
                "How do I search for items?" => "Use our advanced search with filtering and sorting options. You can search by category, brand, calibre, price range, and location. You can also favourite stores and items for easy access later.",
                "Can I make offers on items?" => "Yes, our platform includes offer and counter-offer functionality, allowing negotiation between buyers and sellers before finalizing transactions.",
                "Can I buy items from multiple stores at once?" => "You can only make purchases from a single store at a time. Your purchase can include multiple items from that store.",
                "What happens if I don’t like the item I’ve purchased?" => "Please carefully read item descriptions, view pictures and request additional information from the seller to make sure you are comfortable before making a purchase. Some sellers may include specific terms of purchase such as no refunds/returns in their store bio. Armoury Broker will assist in managing disputes when the item does not arrive or match the item listed for sale, personal preferences will need to be discussed directly with the seller or mitigated by careful review of listings.",
            ],
            "Payments & Fees" => [
                "How much does it cost to use Armoury Broker?" => [
                    "There is no monthly or subscription fee for creating a store on Armoury Broker. The platform charges the following fees:",
                    "<ul><li><b>Platform fee:</b> 5% of the transaction value with a minimum charge of R25.00 per transaction</li></ul>",
                    "When the seller lists an item, they can determine who covers this fee. The following options are available:",
                    "<ul>
                        <li>The seller covers the Platform fee (This is deducted from the funds they receive from the sale)</li>
                        <li>The buyer covers the Platform fee (This is added to the sales price of the item)</li>
                        <li>The buyer and the seller split the Platform fee (Each party pays 50% of the fee)</li>
                    </ul>",
                    "Fee Examples:",
                    "<ul>
                        <li>R500 transaction = R25 fee</li>
                        <li>R1,000 transaction = R50 fee</li>
                        <li>R10,000 transaction = R500 fee</li>
                        <li>R50,000 transaction = R2,500 fee</li>
                    </ul>",
                ],
                "What payment methods do you accept?" => [
                    "We support multiple payment methods including:",
                    "<ul>
                        <li>Traditional EFT</li>
                        <li>Instant EFT (additional transaction charges apply, these will be presented on checkout)</li>
                        <li>Debit/Credit cards (additional transaction charges apply, these will be presented on checkout)</li>
                    </ul>",
                    "Future development is being considered for Apple Pay, Google Pay, and other providers through the secure payment gateway.",
                ],
                "How does the escrow system work?" => "When a buyer makes a payment, funds are held securely in our escrow account until the buyer confirms receipt and approves the item's condition. Only then are funds released to the seller's wallet, ensuring protection for both parties.",
                "How do I get paid as a seller?" => "Once the buyer confirms receipt on the sold item, funds are released to your Armoury Broker wallet. You can then either use these funds for future purchases or request that payment is made to your bank account. This is done via EFT which is processed through our daily payment extraction system. Standard banking turnaround times will apply to the funds reflecting in your nominated bank account.",
                "Can I offer discount codes?" => "We are working to make discount codes available for you to share on your store and via social media. They will be value or percentage based.",
                "Can I buy vouchers?" => "An Armoury Broker voucher is the perfect gift for the firearms enthusiast in your life. These can be purchased on the site. The values are configurable and are valid towards purchases made on the platform. They cannot be redeemed for cash and are valid for 12 months from date of purchase.",
            ],
            "Shipping & Delivery" => [
                "How does shipping work?" => "Armoury Broker collects the funds for the courier during the purchase phase of the transaction. The seller arranges the courier and delivers the item to them for shipping (this happens outside of the platform). Once the item(s) has been confirmed as received by the buyer, Armoury Broker will release the funds to the seller, which will include the agreed purchase price and collected delivery fees (if applicable) less any costs that the seller has chosen to absorb.",
                "What shipping and delivery options are available?" => [
                    "Courier Delivery" => "<ul>
                        <li>The seller selects Courier Delivery as an available delivery option when listing the item. They will need to select a suitable cargo size for the product. The fees will be applied based on the courier’s standard pricing.</li>
                        <li>The buyer will be charged the associated delivery fee (if applicable) during the checkout and payment phase of the transaction, which is paid into the Armoury Broker Escrow account</li>
                        <li>The seller will then ship the item to the agreed destination</li>
                        <li>Once the buyer confirms receipt of the item, the funds for the item and collected delivery fee will be released to the seller's wallet and be made available for withdrawal</li>
                    </ul>",
                    "Collection or Delivery" => "<ul>
                        <li>The seller selects Collection or Delivery as an available delivery option when listing the item</li>
                        <li>The buyer and seller will agree via the platform messaging service on the pickup or drop-off location</li>
                        <li>Once the buyer confirms receipt of the purchased item, the funds for the item will be released to the seller's wallet and be made available for withdrawal</li>
                    </ul>",
                    "Dealer Stocking (Firearms Only)" => "<ul>
                        <li>The seller selects Dealer Stocking as an available delivery option when listing the item</li>
                        <li>The buyer and seller will agree via the platform messaging service as to the most appropriate dealer to be used for dealer stocking</li>
                        <li>The buyer and seller will arrange for dealer stocking of the firearm and complete the necessary paperwork with the dealer</li>
                        <li>All dealer stocking fees are paid to the chosen dealer directly by the buyer</li>
                        <li>Once the firearm is confirmed to have been dealer stocked by the buyer, the funds will be released to the seller's wallet and be made available for withdrawal</li>
                    </ul>"
                ],
                "Does Armoury Broker have a dealer stocking network?" => "Armoury Broker is working on building a dealer network to create a footprint across South Africa. If you would like to join our dealer network, please email support@armourybroker.com or select “join dealer network” under “Profile completion” on your user dashboard.",
                "What happens if my item doesn't arrive?" => "Our escrow system protects you - funds are only released when you confirm receipt (or Dealer Stocking in the case of firearm transactions). If there are issues, you can initiate our formal dispute resolution process for investigation and potential refund.",
                "What happens if I don't obtain my license after the item I have purchased is dealer stocked, and the funds have been released to the seller?" => "The Armoury Broker platform provides a secure trading environment for the buying and selling of firearms and related equipment. Once the firearm has been dealer stocked, the buyer must confirm as such on the platform to allow Armoury Broker to release the funds to the seller. At this stage, the Armoury Broker service offering is complete, and the transaction is deemed to have been finalized. The responsibility for the buyer to obtain their license to possess the firearm resides with the buyer and this is facilitated outside of the platform. Should a license not be obtained for the firearm, the buyer should engage with the dealer where the firearm is stocked to review the options available to them.",
                "Can I track my shipment?" => "Sellers provide tracking details via the platform messaging service when they confirm shipment. Full courier integration with automated tracking will be available in future platform updates.",
            ],
            "Security & Compliance" => [
                "Is Armoury Broker a licensed firearms dealer?" => "No, Armoury Broker is not a licensed firearms dealer. Armoury Broker provides a unified marketplace with secure escrow payments, comprehensive buyer and seller protection, transparent transaction history, and integrated dispute resolution processes. All transactions must comply with South African law and more specifically, the SA Firearms Control Act (60), 2020. The responsibility resides with the platform users to ensure that they remain compliant with all relevant regulations and laws.",
                "How do you ensure legal compliance?" => "We provide clear disclaimers, requiring user confirmation throughout the process regarding regulatory compliance, and we connect you to a suggested dealer network for legal firearm transfers. Users are responsible for ensuring their transactions meet all legal requirements.",
                "How secure is my personal information?" => "We implement bank-grade security measures, secure authentication, comprehensive transaction logging, and maintain detailed audit trails. All data is protected according to industry standards.",
                "What if there's a dispute?" => "We have a formal dispute resolution process: disputes are logged, investigated, and resolved through our support team. If needed, items can be returned to sellers and buyers refunded through our escrow system. Courier costs for the return of items may need to be covered by the buyer.",
            ],
            "Technical Support" => [
                "How do I get help if I have issues?" => "We provide standard business hours support through our dedicated support team, comprehensive help documentation, searchable FAQs, and integrated messaging systems within the platform. You can contact us at support@armourybroker.com.",
                "What browsers are supported?" => "Armoury Broker works on all modern browsers including Chrome, Firefox, Safari, and Edge on desktop and mobile devices.",
                "Will there be a mobile app?" => "Due to the nature of the items available on Armoury Broker, a mobile app is not feasible. The platform is available on your device’s browser, and you can add a shortcut to create an app-like experience.",
                "How can I stay updated on new features?" => "Follow our announcements through the platform notifications, email updates, and our official communications channels on our social media accounts.",
            ],
        ];
    }
}
